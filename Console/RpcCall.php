<?php

namespace MagentoPlus\DataBases\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RpcCall extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Magento\Framework\MessageQueue\PublisherInterface
     */
    private $publisher;

    public function __construct(\Magento\Framework\MessageQueue\PublisherInterface $publisher)
    {
        parent::__construct();
        $this->publisher = $publisher;
    }

    protected function configure()
    {
        $this->setName('magentoplus:rpc:call');
        $this->setDescription('Test rpc call');
        $options = [
            new InputOption(
                'data',
                null,
                InputOption::VALUE_OPTIONAL,
                'Data for set to rpc call'
            )
        ];
        $this->setDefinition($options);
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $topicName = 'test.remote.rpc';
        $data = $input->getOption('data');
        $output->writeln($this->publisher->publish($topicName, $data));
    }
}
