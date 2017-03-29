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
        $username = $response->getUsername();
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    /**
     * @param UserResponseInterface $response
     * @return \FOS\UserBundle\Model\UserInterface|UserInterface
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';
            // create new user here
            $user = $this->userManager->createUser();
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($username);
            $user->setEmail($username);
            $user->setPassword($username);
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
//    /**
//     * @param UserResponseInterface $response
//     * @return \FOS\UserBundle\Model\UserInterface
//     */
//    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
//    {
//        $socialID = $response->getUsername();
//        $user = $this->userManager->findUserBy(array($this->getProperty($response)=>$socialID));
//        $email = $response->getEmail();
//        //check if the user already has the corresponding social account
//        if (null === $user) {
//            //check if the user has a normal account
//            $user = $this->userManager->findUserByEmail($email);
//
//            if (null === $user || !$user instanceof UserInterface) {
//                //if the user does not have a normal account, set it up:
//                $user = $this->userManager->createUser();
//                $user->setEmail($email);
//                $user->setPlainPassword(md5(uniqid()));
//                $user->setEnabled(true);
//            }
//            //then set its corresponding social id
//            $service = $response->getResourceOwner()->getName();
//            switch ($service) {
//                case 'google':
//                    $user->setGoogleID($socialID);
//                    break;
//                case 'facebook':
//                    $user->setFacebookID($socialID);
//                    break;
//            }
//            $this->userManager->updateUser($user);
//        } else {
//            //and then login the user
//            $checker = new UserChecker();
//            $checker->checkPreAuth($user);
//        }
//
//        return $user;
//    }
}