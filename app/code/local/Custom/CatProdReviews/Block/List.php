 <?php
class Custom_CatProdReviews_Block_List extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface {

    public function getReviews()
    {
        $category = Mage::registry('current_category');
        if (is_object($category)) {
            $product_ids = $category->getProductCollection()->getAllIds();
            if (is_array($product_ids) && count($product_ids) > 0) {
                $reviews_count = intval($this->getData('reviews_count')); 
                $reviewscollection = Mage::getModel('review/review')->getCollection()
                ->setPageSize($reviews_count)
                ->addStoreFilter(Mage::app()->getStore()->getId())
                ->addStatusFilter(Mage_Review_Model_Review::STATUS_APPROVED)
                ->addFieldToFilter('entity_id', Mage_Review_Model_Review::ENTITY_PRODUCT)
                ->addFieldToFilter('entity_pk_value', array('in' => $product_ids))
                ->setDateOrder()
                ->addRateVotes();
                return $reviewscollection->getItems();  
            } else {
                return array();
            }  
        }
        return array();
    }  
} 