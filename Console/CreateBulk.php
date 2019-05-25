<?php

namespace MagentoPlus\DataBases\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateBulk extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \MagentoPlus\DataBases\Model\ScheduleBulk
     */
    private $scheduleBulk;

    public function __construct(\MagentoPlus\DataBases\Model\ScheduleBulk $scheduleBulk)
    {
        parent::__construct();
        $this->scheduleBulk = $scheduleBulk;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
       return $this->scheduleBulk->publishMass();
    }

    protected function configure()
    {
        $this->setName('magentoplus:bulk:create');
        $this->setDescription('Test bulk');
        parent::configure();
    }
}
