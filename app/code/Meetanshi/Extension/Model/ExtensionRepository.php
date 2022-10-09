<?php

namespace Meetanshi\Extension\Model;


use Magento\Framework\Api\SearchCriteriaInterface;
use Meetanshi\Extension\Api\Data\ExtensionInterfaceFactory;
use Meetanshi\Extension\Api\Data\ExtensionInterface;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Meetanshi\Extension\Model\ResourceModel\Extension as ResourceExtension;
use Meetanshi\Extension\Model\ResourceModel\Extension\CollectionFactory as ExtensionCollectionFactory;
use Meetanshi\Extension\Api\Data\ExtensionSearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Meetanshi\Extension\Model\ExtensionFactory;


class ExtensionRepository implements ExtensionRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourceExtension
     */
    private $resource;
    /**
     * @var ExtensionCollectionFactory
     */
    private $extensionCollectionFactory;
    /**
     * @var extensionFactory
     */
    private $extensionFactory;


    private $searchResultsFactory;



    /**
     * @param ResourceExtension $resource
     * @param ExtensionCollectionFactory $extensionCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceExtension                      $resource,
        ExtensionCollectionFactory             $extensionCollectionFactory,
        CollectionProcessorInterface           $collectionProcessor,
        SearchCriteriaInterface                $searchResultsFactory,
        ExtensionFactory                       $extensionFactory
    ) {
        $this->resource = $resource;
        $this->extensionCollectionFactory =  $extensionCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->extensionFactory = $extensionFactory;
    }
    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById($id): bool
    {
        return $this->delete($this->getById($id));
    }
    /**
     * @param ExtensionInterface $Extension
     * @return bool
     */
    public function delete(ExtensionInterface $Extension): bool
    {
        try {
            $this->resource->delete($Extension);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the Extension: %1', $exception->getMessage())
            );
        }
        return true;
    }
    /**
     * @param int $id
     * @return ExtensionInterface
     */
    public function getById($id): ExtensionInterface
    {
        $Extension = $this->extensionFactory->create();
        $this->resource->load($Extension, $id);
        if (!$Extension->getId()) {
            throw new NoSuchEntityException(__('The Extension with the "%1" ID doesn\'t exist.', $id));
        }
        return $Extension;
    }
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ExtensionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->extensionCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
    /**
     * @param ExtensionInterface $Extension
     * @return ExtensionInterface
     * @throws CouldNotSaveException
     */
    public function save(ExtensionInterface $Extension): ExtensionInterface
    {
        try {
            $this->resource->save($Extension);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', __('Something went wrong while saving the post.')),
                $exception
            );
        }
        return $Extension;
    }

}
