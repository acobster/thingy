<?php

namespace ThingyCore\Models;

use ThingyCore\Models\Model;

/** @Entity **/
class Page extends Model {
    /** @Id @GeneratedValue @Column(type="integer") **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $title;
    /** @Column(type="text") **/
    protected $content;
    /**
     * @OneToOne(targetEntity="ThingyCore\Models\Page")
     * @JoinColumn(name="parent", referencedColumnName="id")
     **/
    protected $parent;
    
    protected $_tableId = 'p';
    protected $_columns = array( 'id', 'name', 'title', 'content', 'parent' );
}

?>

