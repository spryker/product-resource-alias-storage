<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductResourceAliasStorage;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\Product\Persistence\SpyProductQuery;
use Orm\Zed\ProductStorage\Persistence\SpyProductAbstractStorageQuery;
use Orm\Zed\ProductStorage\Persistence\SpyProductConcreteStorageQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductResourceAliasStorage\Dependency\Facade\ProductResourceAliasStorageToEventBehaviorFacadeBridge;

/**
 * @method \Spryker\Zed\ProductResourceAliasStorage\ProductResourceAliasStorageConfig getConfig()
 */
class ProductResourceAliasStorageDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_EVENT_BEHAVIOR = 'FACADE_EVENT_BEHAVIOR';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PRODUCT = 'PROPEL_QUERY_PRODUCT';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PRODUCT_ABSTRACT = 'PROPEL_QUERY_PRODUCT_ABSTRACT';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PRODUCT_ABSTRACT_STORAGE = 'PROPEL_QUERY_PRODUCT_ABSTRACT_STORAGE';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PRODUCT_CONCRETE_STORAGE = 'PROPEL_QUERY_PRODUCT_CONCRETE_STORAGE';

    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $this->addEventBehaviorFacade($container);

        return $container;
    }

    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $this->addProductAbstractPropelQuery($container);
        $this->addProductPropelQuery($container);
        $this->addProductAbstractStoragePropelQuery($container);
        $this->addProductConcreteStoragePropelQuery($container);

        return $container;
    }

    protected function addEventBehaviorFacade(Container $container): Container
    {
        $container->set(static::FACADE_EVENT_BEHAVIOR, function (Container $container) {
            return new ProductResourceAliasStorageToEventBehaviorFacadeBridge($container->getLocator()->eventBehavior()->facade());
        });

        return $container;
    }

    protected function addProductPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_PRODUCT, $container->factory(function () {
            return SpyProductQuery::create();
        }));

        return $container;
    }

    protected function addProductAbstractPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_PRODUCT_ABSTRACT, $container->factory(function () {
            return SpyProductAbstractQuery::create();
        }));

        return $container;
    }

    protected function addProductAbstractStoragePropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_PRODUCT_ABSTRACT_STORAGE, $container->factory(function () {
            return SpyProductAbstractStorageQuery::create();
        }));

        return $container;
    }

    protected function addProductConcreteStoragePropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_PRODUCT_CONCRETE_STORAGE, $container->factory(function () {
            return SpyProductConcreteStorageQuery::create();
        }));

        return $container;
    }
}
