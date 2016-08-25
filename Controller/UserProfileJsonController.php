<?php

namespace CrisisTextLine\UserProfileBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

use CrisisTextLine\UserProfileBundle\Model\UserProfileUserInterface;
use CrisisTextLine\UserProfileBundle\Entity\UserProfile;
use CrisisTextLine\UserProfileBundle\Form\UserProfileType;

/**
 * UserProfile controller.
 *
 * @Route("/user-profile", options={"expose": true})
 */
class UserProfileJsonController implements ContainerAwareInterface
{
    protected $container;
    protected $em;
    protected $repo;
    protected $fieldRepo;
    protected $valueRepo;
    protected $profileManager;

    protected $userCallback;
    protected $userDataHelper;
    protected $updateInterval;
    protected $reportingIntervals;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->repo = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfile');
        $this->fieldRepo = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField');
        $this->valueRepo = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileValue');
        $this->profileManager = $this->container->get('crisistextline.service.user_profile_manager');

        $userCallback = $this->container->getParameter('crisistextline.user_profile.user_update_callback');
        $this->userCallback['service'] = $this->container->get($userCallback['service']);
        $this->userCallback['method'] = $userCallback['method'];

        $userDataHelper = $this->container->getParameter('crisistextline.user_profile.user_data_helper');
        $this->userDataHelper['service'] = $this->container->get($userDataHelper['service']);
        $this->userDataHelper['method'] = $userDataHelper['method'];

        $this->updateInterval = $this->container->getParameter('crisistextline.user_profile.update_interval');
        $this->reportingIntervals = $this->container->getParameter('crisistextline.user_profile.reporting_intervals');
    }

    /**
     * Find and display a user's UserProfile.
     *
     * @Route("/{id}", name="user_profile_json_get")
     * @Method("GET")
     * @Template()
     */
    public function getAction($id)
    {
        $profile = $this->profileManager->findOrCreateByUserID($id);

        $this->updateSeriesData($profile);
        return new JsonResponse($profile->getPreJSON());
    }

    /**
     * Edit/update a user's UserProfile.
     *
     * @Route("/{id}", name="user_profile_json_put")
     * @Method("PUT")
     * @Template()
     */
    public function putAction($id, Request $request)
    {
        $profile = $this->repo->findByUserId($id);
        $params = $request->request->all();

        $this->setProfileValues($profile, $params);
        return new JsonResponse($profile->getPreJSON());
    }

    /**
    * Ensures profile series data is up to date, according to configured update interval
    *
    * @param UserProfile $profile
    *
    * @return UserProfile $profile
    */
    private function updateSeriesData($profile)
    {
        $paramFields = array();
        $now = new \DateTime();
        foreach ($profile->getValues() as $value) {
            $nowCheck = clone $now;
            $field = $value->getUserProfileField();
            // If profile is new or is being checked past updateInterval time, and field is series and enabled, do the thing
            if ((
                    $value->getTimeLastEdited() < $nowCheck->modify('-' . $this->updateInterval)
                    || $value->getTimeLastEdited() < $profile->getTimeCreated()->modify('+10 seconds')
                )
                && $field->isSeries()
                && $field->getEnabled()
            ) {
                $paramFields[] = $field->getName();
            }
        }

        if (count($paramFields)) {
            // Hit the configured service to get the data
            $data = $this->userDataHelper['service']->{$this->userDataHelper['method']}(
                $profile->getUser(),
                $paramFields,
                $this->reportingIntervals
            );
            $this->setProfileValues($profile, $data);
        }
    }

    /**
    * Set the profile's values according to field name and jsonified values in incoming array
    *
    * @param UserProfile $profile
    * @param array $dataArray
    */
    private function setProfileValues($profile, $dataArray) {
        foreach ($dataArray as $fieldName => $jsonValue) {
            $value = $this->valueRepo->findOneBy(array(
                'userProfile' => $profile,
                'userProfileField' => $this->fieldRepo->findOneByName($fieldName)
            ));
            $value->setValue($jsonValue);
            $this->em->persist($value);
        }
        $this->em->flush();
        $this->userCallback['service']->{$this->userCallback['method']}($profile->getUser(), true);
    }
}
