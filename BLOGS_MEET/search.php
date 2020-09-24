<?php
    require_once("./includes/session.php");
    require_once("./includes/vars.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
    $show = 0;
    $msg = '';
    if(isset($_POST['submit']))
    {
        if(empty($_POST['search']))
        {
            $msg = 'Search Field is Empty';
            $show = 0;
        }
        else
        {
            $display='under ';
            $catAry = array();
            // $categories='AND ';
            $categories='';
            if(!empty($_POST['entertainment']))
            {
                $catAry[] = 'category_id=2 ';
                $display.='entertainment ';
            }
            if(!empty($_POST['politics']))
            {
                $catAry[] = 'category_id=1 ';
                $display.='politics ';
            }
            if(!empty($_POST['sports']))
            {
                $catAry[] = 'category_id=3 ';
                $display.='sports ';
            }
            if(!empty($_POST['science']))
            {
                $catAry[] = 'category_id=4 ';
                $display.='science ';
            }
            // $catAry[] = !empty($_POST['entertainment'])?'category_id=2 ':'';
            // $catAry[] = !empty($_POST['politics'])?'category_id=1 ':'';
            // $catAry[] = !empty($_POST['sports'])?'category_id=3 ':'';
            // $catAry[] = !empty($_POST['science'])?'category_id=4 ':'';
            $temp = array();
            for($i=0;$i<count($catAry);$i++)
                if(!empty($catAry[$i]))
                    $temp[] = $catAry[$i];
            if(count($temp) > 0)
                $categories.=implode('OR ',$temp);
            echo $categories;
            $term = $_POST['search'];
            $search = str_replace(',',' ', $term);
            // $query = "SELECT * from blogs where title ";
            $query = "SELECT * from blogs where ";
            if($categories != '')
            {
                $query.=$categories;
                $query.=' AND title ';
            }
            else
                $query.="title ";
           
            $ary = explode(' ',$search);
            $newAry = array();
            for($i=0; $i<count($ary); $i++)
            {
                // echo $clause[$i].'<br>';
                if(!empty($ary[$i]))
                {
                    $newAry[] = $ary[$i];
                }
            }
            $clause = array();
            foreach($newAry as $ele)
            {
                $clause[] =  "like '%$ele%'";
            }
            $clause = implode(" OR title ",$clause);
            $query.= $clause;
            $query.=" AND approved=1 ";
            // if($categories != 'AND ')
            //     $query.=$categories;
            // echo $query;
            $show = 1;
            $results = mysqli_query($conn,$query) or die("Error while querying the database");
            if(mysqli_num_rows($results) > 0)
            {
?>
                <div class = "search_results">
                    <h2>The following Results were found:</h2>
                    <div class = "search_results_box">
            
<?php
                        while($row = mysqli_fetch_array($results))
                        {
            ?>
                                <!-- <div > -->
                                    <a class = "blog_item" href = "viewBlogFull.php?id=<?php echo $row['blog_id']; ?>">
                                        <img src = "<?php echo $row['imageUrl']; ?>" />
                                        <span class ="title"> <?php echo $row['title']; ?></span>
                                        <span class = "by"><?php echo substr($row['text'],0,50) . '....' ; ?></span>
                                    </a>
                                <!-- </div> -->
                        </div>
                    </div>
<?php
                }
            }
            else
            {
                if($display != 'under ')
                    echo '<div id = "empty_div"><h2 id = "empty">No Results were found for "'.$_POST['search'].' '.$display.'"</h2></div>';
                else
                    echo '<div id = "empty_div"><h2 id = "empty">No Results were found for "'.$_POST['search'].'"</h2></div>';
            }
        }
    }
    if($show === 0)
    {
?>
        <div class = "search">
<?php 
        if(!empty($msg))        
        {
            echo '<h4 class = "error">'.$msg.' <i class = "fa fa-times msg_cut"></i></h4>';
        }
?>
            <form action = "search.php" method="POST" class = "form">
                <h2>Search a Blog</h2>
                <input type = "text" placeholder = "Search Term" name = "search" autocomplete = "off" />
                <div class = "search_category">
                    <label for = "politics">politics</label>
                    <input type ="checkbox" name = "politics" id = "politics"/>
                    <label for = "entertainment">entertainment</label>
                    <input type ="checkbox" name = "entertainment" id = "entertainment"/>
                    <label for = "sports">sports</label>
                    <input type ="checkbox" name = "sports" id = "sports"/>
                    <label for = "science">science</label>
                    <input type ="checkbox" name = "science" id = "science"/>
                </div>      
                <input type = "submit" name = "submit" />
            </form>
        </div>
<?php
    }
    mysqli_close($conn);
    require_once("./includes/footer.php");
?>