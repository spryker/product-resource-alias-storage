<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductResourceAliasStorage\Persistence;

use Orm\Zed\ProductStorage\Persistence\SpyProductAbstractStorage;
use Orm\Zed\ProductStorage\Persistence\SpyProductConcreteStorage;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Spryker\Zed\ProductResourceAliasStorage\Persistence\ProductResourceAliasStoragePersistenceFactory getFactory()
 */
class ProductResourceAliasStorageEntityManager extends AbstractEntityManager implements ProductResourceAliasStorageEntityManagerInterface
{
    public function saveProductAbstractStorageEntity(SpyProductAbstractStorage $productAbstractStorageEntity): void
    {
        $productAbstractStorageEntity->save();
    }

    public function saveProductConcreteStorageEntity(SpyProductConcreteStorage $productConcreteStorageEntity): void
    {
        $productConcreteStorageEntity->save();
    }
}
