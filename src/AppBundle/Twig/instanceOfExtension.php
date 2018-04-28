<?php

namespace AppBundle\Twig;

use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class instanceOfExtension extends \Twig_Extension
{
    public function getTests()
    {
        return array(
             'instanceOfLockedException' => new \Twig_SimpleTest('instanceOfLockedException', array($this, 'instanceOfLockedException')),
             'instanceOfBadCredentialsException' => new \Twig_SimpleTest('instanceOfBadCredentialsException', array($this, 'instanceOfBadCredentialsException')),
        );
    }

    /**
     * Tester si @param variable est une instance de LockedException.
     *
     * @return bool
     */
    public function instanceOfLockedException($variable)
    {
        return $variable instanceof LockedException;
    }

    /**
     * Tester si @param variable est une instance de BadCredentialsException.
     *
     * @return bool
     */
    public function instanceOfBadCredentialsException($variable)
    {
        return $variable instanceof BadCredentialsException;
    }

    public function getName()
    {
        return 'instanceOf';
    }
}
