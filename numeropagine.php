<?php

class Pagine {
  private $maxrighe;
  private $numrighe;

  public function __construct($maxrighe, $numrighe){
    $this->maxrighe = $maxrighe;
    $this->numrighe = $numrighe;
  }

  public function PagineTotali(){
    if($this->numrighe<=$this->maxrighe) {
      return 1;
    } else {
      if($this->numrighe%$this->maxrighe!=0){
        return floor($this->numrighe/$this->maxrighe)+1;
      } else {
        return floor($this->numrighe/$this->maxrighe);
      }
    }
  }

}

?>
