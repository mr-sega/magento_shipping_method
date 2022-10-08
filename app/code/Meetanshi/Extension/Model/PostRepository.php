<?php

namespace Meetanshi\Extension\Model;


use Magento\Framework\Api\SearchCriteriaInterface;
use Meetanshi\Extension\Api\Data\PostInterfaceFactory;
use Meetanshi\Extension\Api\Data\PostInterface;
use Meetanshi\Extension\Api\Data\PostSearchResultInterfaceFactory;
use Meetanshi\Extension\Api\PostRepositoryInterface;
use Meetanshi\Extension\Model\ResourceModel\Extension as ResourcePost;
use Meetanshi\Extension\Model\ResourceModel\Extension\CollectionFactory as PostCollectionFactory;
use Meetanshi\Extension\Model\ResourceModel\Extension\Collection;
use Meetanshi\Extension\Api\Data\PostSearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Meetanshi\Extension\Model\postFactory;


class PostRepository implements PostRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ResourcePost
     */
    private $resource;
    /**
     * @var PostCollectionFactory
     */
    private $collectionFactory;
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @param ResourcePost $resource
     * @param PostCollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourcePost                      $resource,
        PostCollectionFactory             $collectionFactory,
        CollectionProcessorInterface      $collectionProcessor,
        PostFactory                       $postFactory
    ) {
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->postFactory = $postFactory;
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
     * @param PostInterface $post
     * @return bool
     */
    public function delete(PostInterface $post): bool
    {
        try {
            $this->resource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the post: %1', $exception->getMessage())
            );
        }
        return true;
    }
    /**
     * @param int $id
     * @return PostInterface
     */
    public function getById($id): PostInterface
    {
        $post = $this->postFactory->create();
        $this->resource->load($post, $id);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('The post with the "%1" ID doesn\'t exist.', $id));
        }
        return $post;
    }
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
    /**
     * @param PostInterface $post
     * @return PostInterface
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post): PostInterface
    {
        try {
            $this->resource->save($post);
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
        return $post;
    }

}
