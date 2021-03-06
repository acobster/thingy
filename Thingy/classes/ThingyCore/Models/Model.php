<?php 

namespace ThingyCore\Models;

use ThingyCore\Debug;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

abstract class Model {
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em;
    /**
     * @var Repository
     */
    protected $_repo;
    protected $_tableId = 'm';
    
    public function __construct() {

        $modelDirs = array_map(
            function($dir) { return thingy()->coreDir.$dir; },
            thingy()->modelDirs );

        $config = Setup::createAnnotationMetadataConfiguration(
            thingy()->modelDirs, thingy()->debug );
        $this->_em = EntityManager::create( thingy()->db['default'],
            $config );
        $this->_repo = $this->_em->getRepository( get_class($this) );
    }
    
    public function __call( $method, $args ) {
        if( substr( $method, 0, 6 ) == 'findBy' ) {
            $by = strtolower( substr( $method, 6 ) );
            // Should be no unconsumed pieces, 
            // so this page should not have any parents
            $where = array(
                $by => $args[0],
                'parent' => null,
            );
            return $this->_repo->findOneBy( $where );
        }
    }
    
    public function findByNameAndAncestors( $pieces ) {

        // Work our way up the page heirarchy
        $pieces = array_reverse( $pieces );
        $name = array_shift( $pieces );
        
        // get the partially constructed QueryBuilder
        $qb = $this->selectFrom();
            
        foreach( $pieces as $k => $parent ) {
            $alias = ( $k == 0 )
                ? $this->_tableId
                : $this->_tableId . $k;
            $joinAlias = $this->_tableId . ($k+1);
            $foreign = "$alias.parent";
            $on = "$joinAlias.id = $alias.parent"
                . " AND $joinAlias.name = '$parent'";
            $qb = $qb->innerJoin( $foreign, $joinAlias, 'WITH', $on );
        }
        
        $result = $qb->where( "{$this->_tableId}.name = ?1" )
            ->setParameter( 1, $name )
            ->getQuery()
            ->getResult();

        if( empty( $result ) ) {
            // TODO: throw an exception here
            return false;
        }
        
        return $result[0];
    }
    
    public function prepare() {
        
        $data = array();
        foreach( $this->_columns as $v ) {
            if( isset( $this->$v ) ) {
                $data[$v] = $this->$v;
            }
            //else { Debug::error( "Attempting to access null property: $v" ); }
        }
        return $data;
    }
    
    /**
     * Get the partially built QueryBuilder, with SELECT and FROM
     */
    protected function selectFrom() {
        $from = get_class( $this );
        return $qb = $this->_em->createQueryBuilder()
            ->select( $this->_tableId )
            ->from( $from, $this->_tableId );
    }
} 

?>