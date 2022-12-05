<?php


namespace Sega\ChristmasCoins\Model;

use Sega\ChristmasCoins\Api\PointsRepositoryInterface;
use Sega\ChristmasCoins\Api\Data\PointsInterface;
use Sega\ChristmasCoins\Api\Data\PointsSearchResultsInterface;
use Sega\ChristmasCoins\Model\ResourceModel\Points as ResourceModel;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PointsRepository implements PointsRepositoryInterface
{
    private  $resource;
    private  $pointsFactory;
    private  $collectionFactory;
    private  $collectionProcessor;
    private  $searchResultsFactory;

    public function __construct(
        ResourceModel $resource,
        PointsFactory $pointsFactory,
        ResourceModel\Collection $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        PointsSearchResultsFactory $searchResultsFactory
    ) {
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->pointsFactory = $pointsFactory;
        $this->resource = $resource;
    }

    public function delete(PointsInterface $points): bool
    {
        try {
            $this->resource->delete($points);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(
                __('Could not delete the coins transaction: %1', $e->getMessage())
            );
        }

        return true;
    }

    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }

    public function getById($id): PointsInterface
    {
        $coinsTransaction = $this->pointsFactory->create();

        $this->resource->load($coinsTransaction, $id);
        if (! $coinsTransaction->getId()) {
            throw new NoSuchEntityException(__('The coins transaction with the "%1" ID doesn\'t exists.', $id));
        }

        return $coinsTransaction;
    }


    public function save(PointsInterface $points): bool
    {
        try {
            $this->resource->save($points);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('Could not save the coins transaction: %1', $e->getMessage())
            );
        }

        return true;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): PointsSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
