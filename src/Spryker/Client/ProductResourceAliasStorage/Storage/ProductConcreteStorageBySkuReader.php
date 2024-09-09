<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductResourceAliasStorage\Storage;

use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\ProductResourceAliasStorage\Dependency\Client\ProductResourceAliasStorageToStorageClientInterface;
use Spryker\Client\ProductResourceAliasStorage\Dependency\Service\ProductResourceAliasStorageToSynchronizationServiceInterface;
use Spryker\Shared\ProductStorage\ProductStorageConstants;

class ProductConcreteStorageBySkuReader implements ProductConcreteStorageReaderInterface
{
    /**
     * @var string
     */
    protected const REFERENCE_NAME = 'sku:';

    /**
     * @var \Spryker\Client\ProductResourceAliasStorage\Dependency\Client\ProductResourceAliasStorageToStorageClientInterface
     */
    protected $storageClient;

    /**
     * @var \Spryker\Client\ProductResourceAliasStorage\Dependency\Service\ProductResourceAliasStorageToSynchronizationServiceInterface
     */
    protected $synchronizationService;

    /**
     * @param \Spryker\Client\ProductResourceAliasStorage\Dependency\Client\ProductResourceAliasStorageToStorageClientInterface $storageClient
     * @param \Spryker\Client\ProductResourceAliasStorage\Dependency\Service\ProductResourceAliasStorageToSynchronizationServiceInterface $synchronizationService
     */
    public function __construct(
        ProductResourceAliasStorageToStorageClientInterface $storageClient,
        ProductResourceAliasStorageToSynchronizationServiceInterface $synchronizationService
    ) {
        $this->storageClient = $storageClient;
        $this->synchronizationService = $synchronizationService;
    }

    /**
     * @param string $sku
     * @param string $localeName
     *
     * @return array<int|string>|null
     */
    public function findProductConcreteStorageData(string $sku, string $localeName): ?array
    {
        $synchronizationDataTransfer = new SynchronizationDataTransfer();
        $synchronizationDataTransfer
            ->setReference(static::REFERENCE_NAME . $sku)
            ->setLocale($localeName);

        $key = $this->synchronizationService
            ->getStorageKeyBuilder(ProductStorageConstants::PRODUCT_CONCRETE_RESOURCE_NAME)
            ->generateKey($synchronizationDataTransfer);
        $mappingResource = $this->storageClient->get($key);
        if (!$mappingResource) {
            return null;
        }

        $productConcreteId = $mappingResource['id'] ?? null;
        if ($productConcreteId === null) {
            return null;
        }

        $key = $this->getProductConcreteStorageResourceKey($productConcreteId, $localeName);

        return $this->storageClient->get($key);
    }

    /**
     * @param int $productConcreteId
     * @param string $localeName
     *
     * @return string
     */
    protected function getProductConcreteStorageResourceKey(int $productConcreteId, string $localeName): string
    {
        $synchronizationDataTransfer = new SynchronizationDataTransfer();
        $synchronizationDataTransfer
            ->setReference((string)$productConcreteId)
            ->setLocale($localeName);

        return $this->synchronizationService
            ->getStorageKeyBuilder(ProductStorageConstants::PRODUCT_CONCRETE_RESOURCE_NAME)
            ->generateKey($synchronizationDataTransfer);
    }
}
