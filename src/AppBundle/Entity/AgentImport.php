<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Util\Util;

/**
 * AgentImport.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AgentImportRepository")
 */
class AgentImport extends Agent
{
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Email(
     *     message = "Email N+1 : {{ value }} n'est pas un email valide.",
     *     checkMX = false,
     *     groups={"importCSV", "Default"}
     * )
     */
    protected $emailShd;

    /**
     * @var string
     *
     * @ORM\Column(name="email_ah", type="string", nullable=true)
     * @Assert\Email(
     *     message = "Email N+2 : {{ value }} n'est pas un email valide.",
     *     checkMX = false,
     *     groups={"importCSV", "Default"}
     * )
     */
    protected $emailAh;

    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    /**
     * Set emailShd.
     *
     * @param string $emailShd
     *
     * @return Agent
     */
    public function setEmailShd($emailShd)
    {
        $this->emailShd = $emailShd ? strtolower($emailShd) : $emailShd;

        return $this;
    }

    /**
     * Get emailShd.
     *
     * @return string
     */
    public function getEmailShd()
    {
        return $this->emailShd;
    }

    /**
     * Set emailAh.
     *
     * @param string $emailAh
     *
     * @return Agent
     */
    public function setEmailAh($emailAh)
    {
        if ($emailAh) {
            $this->emailAh = strtolower($emailAh);
        }

        return $this;
    }

    /**
     * Get emailAh.
     *
     * @return string
     */
    public function getEmailAh()
    {
        return $this->emailAh;
    }

    /**
     * @Assert\Callback(groups={"importCSV", "Default"})
     */
    public function validateAgentImport(ExecutionContextInterface $context)
    {
        if ($this->emailShd && !Util::validerEmail($this->emailShd)) {
            $context->buildViolation('L\'email du N+1 n\'est pas valide')
                ->atPath('emailShd')
                ->addViolation();
        }

        if ($this->emailAh && !Util::validerEmail($this->emailAh)) {
            $context->buildViolation('L\'email du N+2 n\'est pas valide')
            ->atPath('emailAh')
            ->addViolation();
        }
    }
}
