<?php
    require_once("./includes/loader.php");
    require_once("./includes/connection.php");
    $searchTerm = empty($_POST['searchTerm']) ? '':$_POST['searchTerm'];
    $searchWord = strtolower($searchTerm);
    $searchAry = explode(" ",$searchWord);
    for($i = 0; $i<count($searchAry);$i++)
    {
        if($searchAry[$i] == ',' || $searchAry[$i] == '.' || $searchAry[$i] == '!' || $searchAry[$i] == '@')
        {
            array_shift($searchAry);
        }
    }
    $sql = "SELECT * FROM users WHERE ";
    for($i = 0; $i<count($searchAry);$i++)
    {
        if($i == count($searchAry) - 1)
            $sql.= "username LIKE '%$searchAry[$i]%'";
        else
            $sql.="username LIKE '%$searchAry[$i]%' OR ";
    }
    // echo $sql;
    $searchResults = ''; 
    $result = mysqli_query($conn,$sql);
    if($result)
    {
       $searchResults = array();
       while($row = mysqli_fetch_assoc($result))
       {
           $searchResults[] = $row;
       } 
    }
    else
    {
        $searchResults = 'An Error occured';
    }
    // $searchResults = $userObj->getSearchResults($searchTerm);
    if(count($searchResults) > 0)
    {
        ?>
        <div>
        <?php
        foreach($searchResults as $result)
        {
            $obj = new User();
            $userData = $obj->getUserWithId($result['user_id']);
            ?>
            <div>
                <img src = "<?php echo $userData['imageUrl'];  ?>" alt = "error" />
                <h2>
                    <?php
                        echo $userData['username'];
                    ?>
                </h2>
                <a href = "profile.php?user_id=<?php echo $userData['user_id']; ?>">View Profile</a>
            </div>
            <?php
        }
        ?>
        </div>
        <?php
    }
    else
    {
        ?>
        <h4>No Results found matching " <?php echo $searchTerm; ?> " </h4>
        <?php
    }
    mysqli_close($conn);
?>