<?php
class B4BWP
{

    /* class properties */
    private $enqueued = array();
    private $features = array();
    private $menus = array();
    private $styled = array();

    /* constructor */
    public function __construct(  )
    {
        // Assign values to class properties
  
    }

    public function setScripts($enqueued)
    { 
        //var_dump($enqueued );
    
        $this->enqueued = array_merge($this->enqueued ,$enqueued);
        //add_action( 'wp_enqueue_scripts', array( $this, 'EnqueueScripts' ) );
      //  add_action( 'wp_enqueue_scripts', 'EnqueueScripts' );
    }


    public function EnqueueScripts()
    {
        //die();
        //var_dump($this->enqueued);
        
        if( is_array( $this->enqueued ) && ! empty( $this->enqueued ) )
        {
            foreach ( $this->enqueued as $val ) {
              //  var_dump($value);
                //foreach ( $value as $val ) {
               // var_dump($val);
                wp_enqueue_script(
                    $val['name'],
                    $val["location"]
                 //   null, ///array("jquery"),
                 //   $value["version"],
                   // true
                );
            //}
            }
        }
    }

    public function doScripts()
    { 
       // $this->enqueued = $enqueued;
     //  var_dump($this->enqueued);
        add_action( 'wp_enqueue_scripts', array( $this, 'EnqueueScripts' ) );
      //  add_action( 'wp_enqueue_scripts', 'EnqueueScripts' );
    }

}