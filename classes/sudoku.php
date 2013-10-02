<?php
    class sudoku
    {
        private $array=array();
        
        public function __construct(){
            $this->createemptyarray();
            $this->validation();
            $this->tabledisplay();  
        }
        public function getcomplete(){
            return $this->array;
        }
        private function display(){
            for($x=0;$x<9;$x++){
                for($y=0;$y<9;$y++){
                    echo $this->array[$x][$y];
                }
                echo "<br />";
            }
        }
        private function createemptyarray(){
            for($x=0;$x<9;$x++){
                for($y=0;$y<9;$y++){
                    $this->array[$x][$y]=0;
                }
            }
        }
        private function tabledisplay(){
            $html="<table style='font-size: 48px;'>";
            for($x=0;$x<9;$x++){
                $html.="<tr>";
                for($y=0;$y<9;$y++){
                    $html.= "<td><p class='numberbox'>".$this->array[$x][$y]."</p></td>";
                }
                $html.="</tr>";
            }
            $html.="</table>";
            echo $html;
        }
        
        // Construct the sudoku table using a backtrack algorithm
        private function validation($position=0){
            if($position==9*9){
                return true;
            }
            if($position==0){
            $rows = array(1,2,3,4,5,6,7,8,9);
            shuffle($rows); // First line is a random result line
            $this->array[1]=$rows;
            $this->validation($position+9);
            }
            
            (int)$row = $position / 9;
            $col = $position % 9;
            
            for($number=1;$number <= 9;$number++){
                if($this->linechecker($row,$number) && $this->columnchecker($col,$number) && $this->regionchecker($row,$col,$number)){
                    $this->array[$row][$col]=$number;
                    if($this->validation($position+1))
                    {return true;}
                }
            }
            
            $this->array[$row][$col] = 0;
            return false;
             
        }
        
        // Check the line if the number exists
        private function linechecker($line,$nbr){
            for($tempnbrs=0;$tempnbrs<9;$tempnbrs++){
                if($this->array[$line][$tempnbrs]==$nbr){
                    return false;
                }
            }
            return true;
        }
        
        // Check the column if the number exists
        private function columnchecker($column,$nbr){
            for($tempnbrs=0;$tempnbrs<9;$tempnbrs++){
                if($this->array[$tempnbrs][$column]==$nbr){
                    return false;
                }
            }
            return true;
        }
        
        // Check the 3*3 region if the number exists
        private function regionchecker($line,$column,$nbr){
            (int)$_line=$line-($line%3);
            (int)$_column=$column-($column%3);
            for($line=$_line;$line<$_line+3;$line++){
                for($column=$_column;$column<$_column+3;$column++){
                    if($this->array[$line][$column]==$nbr)
                        return false;
                }
            }
            return true;
        }
    }
?>