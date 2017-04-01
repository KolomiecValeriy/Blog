<?php

namespace Kolomiets\BlogBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

class OAuthUserProvider extends BaseClass
{
    /**
     * @param UserInterface $user
     * @param UserResponseInterface $response
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $userName = $response->getUsername();
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($service);
        $setServiceId = $setter.'Id';
        $setServiceToken = $setter.'AccessToken';
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $userName))) {
            $previousUser->$setServiceId(null);
            $previousUser->$setServiceToken(null);
            $this->userManager->updateUser($previousUser);
        }
        //we connect current user
        $user->$setServiceId($userName);
        $user->$setServiceToken($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    /**
     * @param UserResponseInterface $response
     * @return \FOS\UserBundle\Model\UserInterface|UserInterface
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userName = $response->getUsername();
        $userFullName = $response->getRealName();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $userName));
        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setServiceId = $setter.'Id';
            $setServiceToken = $setter.'AccessToken';
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setServiceId($userName);
            $user->$setServiceToken($response->getAccessToken());

            $user->setUsername($userFullName);
            $user->setEmail($userName);
            $user->setPassword($userName);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);
            return $user;
        }
        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        //update access token
        $user->$setter($response->getAccessToken());

        return $user;
    }
}