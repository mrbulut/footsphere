<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 12:09
 */
include_once ROOT_PATH . "/src/entities/concrete/ProductConcrete.php";
include_once ROOT_PATH . "/src/entities/abstract/Container.php";
include_once ROOT_PATH . "/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH . "/src/data/abstract/IDatabaseTableDao.php";

class ProductDal extends DatabaseTableDao
{
    private $Rows;

    private $wp_postDal;

    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new Product()),"a_fs_Product");
        $this->wp_postDal = new wp_postsDal();
    }


    public function addProductReal(Product $product, $UserId)
    {
        $productId = $this->wp_postDal->addProduct(
            $product->PName,
            $product->DescProduct,
            $product->Image,
            $product->Price,
            $product->ID,
            $product->ProducerNO,
            $UserId);

        if ($productId) {
            return $productId;
        } else
            return false;
    }

    public function updateProductReal(Product $product)
    {
        if ($product->getPName()) {
            $this->wp_postDal->setName($product->getID(), $product->getPName());
        }

        if ($product->getDesc()) {
            $this->wp_postDal->setDesc($product->getID(), $product->getDesc());
        }

        if ($product->getPrice()) {
            $this->wp_postDal->setPrice($product->getID(), $product->getPrice());
        }

        if ($product->getImage()) {
            $this->wp_postDal->setImage($product->getID(), $product->getImage());
        }
    }

    public function deleteProductRealForUser($ProductNo, $UserId)
    {
        return $this->wp_postDal->deleteProductForUser($ProductNo, $UserId);
    }

    public function deleteProductReal($ProductNo)
    {
        return $this->wp_postDal->deleteProductAll($ProductNo);
    }

    public function removeProductForUser($ProductId, $UserId)
    {
        return $this->wp_postDal->removePermissionForUser($ProductId, $UserId);
    }


}

class wp_postsDal extends DatabaseTableDao
{

    private $Column = array(
        'ID',
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count'
    );
    private $PostMetaDatabase;
    private $PostMetaWhereObject;

    public function __construct()
    {
        parent::CreateTable(Container::getInstance(new wp_postsConcrete()), "wp_posts");
        $this->PostMetaDatabase = new wp_postMetaDal();
        $this->PostMetaWhereObject = new wp_postsConcrete();

    }

    public function getProduct($ID)
    {
        if ($ID) {
            $product = $this->select(
                array(
                    'ID' => $ID
                )
            );
            $returnArray['name'] = $product['post_title'];
            $returnArray['desc'] = $product['post_excerpt'];
            $returnArray['productlink'] = $product['guid'];
            $returnArray['price'] = self::getPrice($ID);
        } else
            return false;


    }

    public function addProduct($Name, $Desc, $imageName, $Price, $ProductNo, $ProducerNo, $UserId)
    {

        $randomSayi = rand(2, 500340);
        $valueArray = array(
            1,
            self::now(),
            self::now(),
            '',
            $Name,
            $Desc,
            'publish',
            'open',
            'closed',
            '',
            $ProductNo . "_" . $UserId,
            '',
            'bespoke_' . $ProductNo,
            self::now(),
            self::now(),
            '',
            0,
            "/product/" . $ProducerNo . "" . $randomSayi . "" . $Price,
            0,
            'product',
            '',
            0
        );
        $dateArray = array();
        $i = 1;

        foreach ($valueArray as $key => $value) {
            $dateArray[$this->Column[$i]] = $value;
            $i++;

        }
        $ProductID = $this->insert($dateArray);

        //-----------------------------//
        if ($ProductID) {
            $ImageID = self::addImage($ProductID, $imageName);
            if ($ImageID) {
                self::addPrice($ProductID, $Price, $UserId);
                return $ProductID;
            }
        } else {
            return false;
        }
    }

    public function deleteProductForUser($ProductNo, $UserId)
    {
        if ($ProductNo and $UserId) {
            $id = $this->select(
                array(
                    'pinged' => "bespoke_" . $ProductNo,
                    'post_name' => $ProductNo . "_" . $UserId
                )
            );

            if ($id) {
                $id = $id['ID'];
                return $this->delete(
                    array(
                        'ID' => $id
                    )
                );
            }
        } else
            return false;

    }

    public function deleteProductAll($ProductNo)
    {
        $IdArray = self::getIdArrayByProduct($ProductNo);
        foreach ($IdArray as $key => $value) {
            $this->delete(
                array(
                    $this->Column[0] => $value
                )
            );

            $this->delete(
                array(
                    'post_parent' => $value
                )
            );
        }

        $this->removePermissionAll($ProductNo);
    }

    public function setName($ProductNo, $Name)
    {
        $IdArray = self::getIdArrayByProduct($ProductNo);

        foreach ($IdArray as $key => $value) {
            $this->update(
                array(
                    'post_title' => $Name,

                ),
                array(
                    $this->Column[0]  => $value
                )
            );
        }

    }

    public function setDesc($ProductNo, $Desc)
    {
        $IdArray = self::getIdArrayByProduct($ProductNo);

        foreach ($IdArray as $key => $value) {
            $this->update(
                array(
                    'post_title' => $Desc,

                ),
                array(
                    $$this->Column[0]  => $value
                )
            );
        }
    }

    public function setImage($ProductNo, $Image)
    {
        $IdArray = self::getIdArrayByProduct($ProductNo);
        foreach ($IdArray as $key => $value) {
            $this->update(
                array(
                    'post_title' => $Image,
                    'guid' => $Image,
                ),
                array(
                    'post_parent' => $value
                )
            );
        }
    }

    public function addImage($ProductID, $imageName)
    {
        $ImageArray = array(
            '1',
            self::now(),
            self::now(),
            '',
            $imageName,
            '',
            'inherit',
            'open',
            'closed',
            '',
            $imageName,
            '',
            '',
            self::now(),
            self::now(),
            '',
            $ProductID,
            $imageName,
            0,
            'attachment',
            'image/jpg',
            0);
        $ImageTableArray = array();
        $i = 1;
        foreach ($ImageArray as $key => $value) {
            $ImageTableArray[$this->Column[$i]] = $value;
            $i++;
        }
        $ImageID = $this->insert($ImageTableArray);

        return $ImageID;
    }

    public function getProductLink($PostId)
    {
        return $this->select(
            array(
                'post_id' => $PostId
            )
        );
    }

    public function removePermissionForUser($ProductId, $UserId)
    {
        return $this->PostMetaDatabase->removePermissionForUser($ProductId, $UserId);
    }

    public function removePermissionAll($ProductNo)
    {
        $IdArray = self::getIdArrayByProduct($ProductNo);
        foreach ($IdArray as $key => $value) {
            $this->PostMetaDatabase->removePermissionAll($value);
        }
    }

    public function setProductLink($PostId, $ProductLink)
    {
        if ($PostId) {
            return $this->update(
                array(
                    'guid' => $ProductLink,

                ),
                array(
                    $this->Column[0]  => $PostId
                )
            );


        } else
            return false;
    }

    public function setPrice($ProductNo, $Price)
    {
        $IdArray = self::getIdArrayByProduct($ProductNo);
        foreach ($IdArray as $key => $value) {
            $this->PostMetaDatabase->setPrice($value, $Price);
        }
    }

    public function getPrice($PostId)
    {
        return $this->PostMetaDatabase->getPrice($PostId);
    }

    public function addPrice($PostId, $Price, $UserId)
    {
        return $this->PostMetaDatabase->addPrice($PostId, $Price, $UserId);
    }

    public function getIdArrayByProduct($ProductNo)
    {
        $IdArray = array();
        $return = $this->selectAll(
            array(
                'pinged' => "bespoke_" . $ProductNo
            )
        );

        $i = 0;
        foreach ($return as $key => $value) {
            if ($key == "ID")
                $IdArray [$i] = $value;
            $i++;
        }
        return $IdArray;
    }

}

class wp_postsConcrete implements IEntity
{
    public $ID;
    public $post_author;
    public $post_date;
    public $post_date_gmt;
    public $post_content;
    public $post_title;
    public $post_excerpt;
    public $post_status;
    public $comment_status;
    public $ping_status;
    public $post_password;
    public $post_name;
    public $to_ping;
    public $pinged;
    public $post_modified;
    public $post_modified_gmt;
    public $post_content_filtered;
    public $post_parent;
    public $guid;
    public $menu_order;
    public $post_type;
    public $post_mime_type;
    public $comment_count;

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getPostAuthor()
    {
        return $this->post_author;
    }

    /**
     * @param mixed $post_author
     */
    public function setPostAuthor($post_author)
    {
        $this->post_author = $post_author;
    }

    /**
     * @return mixed
     */
    public function getPostDate()
    {
        return $this->post_date;
    }

    /**
     * @param mixed $post_date
     */
    public function setPostDate($post_date)
    {
        $this->post_date = $post_date;
    }

    /**
     * @return mixed
     */
    public function getPostDateGmt()
    {
        return $this->post_date_gmt;
    }

    /**
     * @param mixed $post_date_gmt
     */
    public function setPostDateGmt($post_date_gmt)
    {
        $this->post_date_gmt = $post_date_gmt;
    }

    /**
     * @return mixed
     */
    public function getPostContent()
    {
        return $this->post_content;
    }

    /**
     * @param mixed $post_content
     */
    public function setPostContent($post_content)
    {
        $this->post_content = $post_content;
    }

    /**
     * @return mixed
     */
    public function getPostTitle()
    {
        return $this->post_title;
    }

    /**
     * @param mixed $post_title
     */
    public function setPostTitle($post_title)
    {
        $this->post_title = $post_title;
    }

    /**
     * @return mixed
     */
    public function getPostExcerpt()
    {
        return $this->post_excerpt;
    }

    /**
     * @param mixed $post_excerpt
     */
    public function setPostExcerpt($post_excerpt)
    {
        $this->post_excerpt = $post_excerpt;
    }

    /**
     * @return mixed
     */
    public function getPostStatus()
    {
        return $this->post_status;
    }

    /**
     * @param mixed $post_status
     */
    public function setPostStatus($post_status)
    {
        $this->post_status = $post_status;
    }

    /**
     * @return mixed
     */
    public function getCommentStatus()
    {
        return $this->comment_status;
    }

    /**
     * @param mixed $comment_status
     */
    public function setCommentStatus($comment_status)
    {
        $this->comment_status = $comment_status;
    }

    /**
     * @return mixed
     */
    public function getPingStatus()
    {
        return $this->ping_status;
    }

    /**
     * @param mixed $ping_status
     */
    public function setPingStatus($ping_status)
    {
        $this->ping_status = $ping_status;
    }

    /**
     * @return mixed
     */
    public function getPostPassword()
    {
        return $this->post_password;
    }

    /**
     * @param mixed $post_password
     */
    public function setPostPassword($post_password)
    {
        $this->post_password = $post_password;
    }

    /**
     * @return mixed
     */
    public function getPostName()
    {
        return $this->post_name;
    }

    /**
     * @param mixed $post_name
     */
    public function setPostName($post_name)
    {
        $this->post_name = $post_name;
    }

    /**
     * @return mixed
     */
    public function getToPing()
    {
        return $this->to_ping;
    }

    /**
     * @param mixed $to_ping
     */
    public function setToPing($to_ping)
    {
        $this->to_ping = $to_ping;
    }

    /**
     * @return mixed
     */
    public function getPinged()
    {
        return $this->pinged;
    }

    /**
     * @param mixed $pinged
     */
    public function setPinged($pinged)
    {
        $this->pinged = $pinged;
    }

    /**
     * @return mixed
     */
    public function getPostModified()
    {
        return $this->post_modified;
    }

    /**
     * @param mixed $post_modified
     */
    public function setPostModified($post_modified)
    {
        $this->post_modified = $post_modified;
    }

    /**
     * @return mixed
     */
    public function getPostModifiedGmt()
    {
        return $this->post_modified_gmt;
    }

    /**
     * @param mixed $post_modified_gmt
     */
    public function setPostModifiedGmt($post_modified_gmt)
    {
        $this->post_modified_gmt = $post_modified_gmt;
    }

    /**
     * @return mixed
     */
    public function getPostContentFiltered()
    {
        return $this->post_content_filtered;
    }

    /**
     * @param mixed $post_content_filtered
     */
    public function setPostContentFiltered($post_content_filtered)
    {
        $this->post_content_filtered = $post_content_filtered;
    }

    /**
     * @return mixed
     */
    public function getPostParent()
    {
        return $this->post_parent;
    }

    /**
     * @param mixed $post_parent
     */
    public function setPostParent($post_parent)
    {
        $this->post_parent = $post_parent;
    }

    /**
     * @return mixed
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * @param mixed $guid
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
    }

    /**
     * @return mixed
     */
    public function getMenuOrder()
    {
        return $this->menu_order;
    }

    /**
     * @param mixed $menu_order
     */
    public function setMenuOrder($menu_order)
    {
        $this->menu_order = $menu_order;
    }

    /**
     * @return mixed
     */
    public function getPostType()
    {
        return $this->post_type;
    }

    /**
     * @param mixed $post_type
     */
    public function setPostType($post_type)
    {
        $this->post_type = $post_type;
    }

    /**
     * @return mixed
     */
    public function getPostMimeType()
    {
        return $this->post_mime_type;
    }

    /**
     * @param mixed $post_mime_type
     */
    public function setPostMimeType($post_mime_type)
    {
        $this->post_mime_type = $post_mime_type;
    }

    /**
     * @return mixed
     */
    public function getCommentCount()
    {
        return $this->comment_count;
    }

    /**
     * @param mixed $comment_count
     */
    public function setCommentCount($comment_count)
    {
        $this->comment_count = $comment_count;
    }

    function ResetObject()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    public function __construct()
    {

    }


}

class wp_postMetaDal extends DatabaseTableDao
{

    private static $Rows;

    private $meta_keys = array(
        "Price" => array(
            "_regular_price", "_price"
        )
    );

    public function __construct()
    {
        $this->Rows = parent::CreateTable(Container::getInstance(new wp_postsMetaConcrete()), "wp_postmeta");
    }

    public function getPrice($PostId)
    {
        return $this->select(
            array(
                'post_id' => $PostId,
                'meta_key' => $this->meta_keys['Price'][0]
            )
        );
    }

    public function setPrice($PostId, $price)
    {

        if ($PostId) {
            $bolean = $this->update(
                array(
                    'meta_key' => $this->meta_keys['Price'][0],
                    'meta_value' => $price,
                ),
                array(
                    'post_id' => $PostId
                )
            );

            if ($bolean) {
                return $this->update(
                    array(
                        'meta_key' => $this->meta_keys['Price'][1],
                        'meta_value' => $price,
                    ),
                    array(
                        'post_id' => $PostId
                    )
                );
            }
        } else {
            return false;
        }

    }

    public function addPermission($ProductId, $UserId)
    {
        return $this->update(
            array(
                'post_id' => $ProductId,
                'meta_key' => 'aam-post-access-user' . $UserId,
                'meta_value' => 'a:2:{s:13:"frontend.list";s:1:"0";s:13:"frontend.read";s:1:"0";}'
            )
        );
    }

    public function removePermissionAll($ProductId)
    {
        return $this->delete(
            array(
                'post_id' => $ProductId
            )
        );
    }

    public function removePermissionForUser($ProductId, $UserId)
    {
        return $this->delete(
            array(
                'post_id' => $ProductId,
                'meta_key' => 'aam-post-access-user' . $UserId
            )
        );
    }

    public function addPrice($PostId, $price, $UserId)
    {

        $arrayValue = array(
            "_wc_review_count" => '0',
            "_wc_rating_count" => 'a:0:{}',
            "_wc_average_rating" => '0',
            "_edit_lock" => '1542781539:1',
            "_edit_last" => '1',
            "_thumbnail_id" => '9',
            "_sku" => '',
            "_regular_price" => $price,
            "_sale_price" => '',
            "_sale_price_dates_from" => '',
            "_sale_price_dates_to" => '',
            "total_sales" => '',
            "_tax_status" => 'taxable',
            "_tax_class" => '',
            "_manage_stock" => 'no',
            "_backorders" => 'no',
            "_low_stock_amount" => '',
            "_sold_individually" => 'no',
            "_weight" => '',
            "_length" => '',
            "_width" => '',
            "_height" => '',
            "_upsell_ids" => 'a:0:{}',
            "_crosssell_ids" => 'a:0:{}',
            "_purchase_note" => '',
            "_default_attributes" => 'a:0:{}',
            "_virtual" => 'no',
            "_downloadable" => 'no',
            "_product_image_gallery" => '',
            "_download_limit" => '-1	',
            "_download_expiry" => '-1',
            "_stock" => '',
            "_stock_status" => 'instock',
            '_product_version' => '3.5.1',
            '_price' => $price,
            'uretici_price' => $price,
            'aam-post-access-visitor' => 'a:2:{s:13:"frontend.list";s:1:"1";s:13:"frontend.read";s:1:"1";}',
            'aam-post-access-rolesubscriber' => 'a:2:{s:13:"frontend.list";s:1:"1";s:13:"frontend.read";s:1:"1";}',
            'aam-post-access-user' . $UserId => 'a:2:{s:13:"frontend.list";s:1:"0";s:13:"frontend.read";s:1:"0";}'
            // burdan sonrasi izinle alakalı
        );

        foreach ($arrayValue as $key => $value) {
            $this->insert(
                array(
                    'post_id' => $PostId,
                    'meta_key' => $key,
                    'meta_value' => $value
                )
            );

        }

    }


}

class wp_postsMetaConcrete implements IEntity
{

    public $meta_id;
    public $post_id;
    public $meta_key;

    /**
     * @return mixed
     */
    public function getMetaId()
    {
        return $this->meta_id;
    }

    /**
     * @param mixed $meta_id
     */
    public function setMetaId($meta_id)
    {
        $this->meta_id = $meta_id;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    /**
     * @return mixed
     */
    public function getMetaKey()
    {
        return $this->meta_key;
    }

    /**
     * @param mixed $meta_key
     */
    public function setMetaKey($meta_key)
    {
        $this->meta_key = $meta_key;
    }

    /**
     * @return mixed
     */
    public function getMetaValue()
    {
        return $this->meta_value;
    }

    /**
     * @param mixed $meta_value
     */
    public function setMetaValue($meta_value)
    {
        $this->meta_value = $meta_value;
    }

    public $meta_value;

    function ResetObject()
    {
        foreach ($this as $key => $value) {
            unset($this->$key);
        }
    }

    public function __construct()
    {

    }


}


