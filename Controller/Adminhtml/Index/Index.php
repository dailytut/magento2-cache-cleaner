<?php

declare(strict_types=1);

namespace W3cert\CacheCleaner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Cache\Manager as CacheManager;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\CacheInvalidate\Model\PurgeCache;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'W3cert_CacheCleaner::cache_cleaner';

    public function __construct(
        Context $context,
        private readonly CacheManager $cacheManager,
        private readonly PurgeCache $varnishPurger,
        private readonly TypeListInterface $cacheTypeList
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        try {
            $types = array_keys($this->cacheTypeList->getTypes());
            $this->cacheManager->clean($types);
            $this->messageManager->addSuccessMessage(__('Magento cache cleared.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Magento cache error: %1', $e->getMessage()));
        }

        try {
            $this->varnishPurger->sendPurgeRequest('.*');
            $this->messageManager->addSuccessMessage(__('Varnish cache purged.'));
        } catch (\Exception $e) {
            $this->messageManager->addNoticeMessage(__('Varnish purge skipped: %1', $e->getMessage()));
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('adminhtml/dashboard/index');
    }
}
