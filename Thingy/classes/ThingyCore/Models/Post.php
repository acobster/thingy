<?php

namespace ThingyCore\Models;

use ThingyCore\Models\Model;

class Post extends Model {
    /** @Id @GeneratedValue @Column(type="integer") **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $title;
    /** @Column(type="text") **/
    protected $content;
    /** @Column(type="integer") **/
    protected $status;
    /** @Column(type="text") **/
    protected $author;
    /** @Column(type="boolean") **/
    protected $comments_enabled;
    
    protected $_tableId = 'p';
    protected $_columns = array( 'id', 'name', 'title', 'content' );
}

?>