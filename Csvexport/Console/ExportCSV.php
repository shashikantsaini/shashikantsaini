<?php
namespace Bluethink\Csvexport\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCSV extends Command
{ 
    const XML_PATH_MODULE_ENABLE = 'update/general/enable';

    const XML_PATH_START_DATE = 'update/general/start_date';

    const XML_PATH_END_DATE = 'update/general/end_date';
    
    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->scopeConfig = $scopeConfig;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('customer:exportcsv');
        $this->setDescription('Command line for CSV Export');
        
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $module = $this->scopeConfig->getValue(self::XML_PATH_MODULE_ENABLE, $storeScope);
        $fromDate = $this->scopeConfig->getValue(self::XML_PATH_START_DATE, $storeScope);
        $toDate = $this->scopeConfig->getValue(self::XML_PATH_END_DATE, $storeScope);
        if($module == 1)
        {
            $filepath = 'export/customerlist.csv';
            $this->directory->create('export');
            $stream = $this->directory->openFile($filepath, 'w+');
            $stream->lock();
    
            $header = ['Id', 'Name', 'Email', 'Created At'];
            $stream->writeCsv($header);
    
            $collection = $this->customerCollectionFactory->create();

            $collection->addAttributeToFilter('created_at', [
                'from' => $fromDate,
                'to' => $toDate,
                'date'=> true
            ]);
            //$output->writeln(print_r($collection->getData()));
            /*foreach ($collection as $customer) {
                $data = [];
                $data[] = $customer->getId();
                $data[] = $customer->getName();
                $data[] = $customer->getEmail();
                $data[] = $customer->getCreatedAt();
                $stream->writeCsv($data);
                $output->writeln($data[0]."  ".$data[1]."  ".$data[2]."  ".$data[3]);
            }*/
            $output->writeln($fromDate."  ".$toDate);
            $output->writeln(print_r($collection->getData()));
        }
        else
        {
            $output->writeln("Your Module is Disable");
        }
        
    }
}