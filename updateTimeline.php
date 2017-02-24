<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css">
        
        <script src="Styles/sorttable.js"></script>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            
                                                       <?php 
                                                       require 'Model/JobModel.php';
                                                       require 'Model/NotificationTypeModel.php';
                                                       require 'Model/QualificationModel.php';
                                                       require 'Model/TypeModel.php';
                                                       require 'Model/FollowingModel.php';
                                                       require 'Model/FollowingTimelineModel.php';
                                                       require 'Model/UserModel.php';
                                                       session_start();
                                                        if(!isset($_SESSION['username']))
                                                        {
                                                            header('Location: index.php');
                                                        }
                                                        
                                                            $epr='';
if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}
$select = 0;
if($epr=='view')
{
    $select = $_GET['select'];
}

                                                         $followingModel = new FollowingModel();
                                                         $searc = $followingModel->GetFollowersByUserId($_SESSION['id']);
                                                         $followingTimelineModel = new FollowingTimelineModel();
                                                         $Timeline = $followingTimelineModel->GetAllTimelineEvents();
                                                         $userModel = new UserModel();
                                                         $notificationTypeModel = new NotificationTypeModel();
                                                         $jobModel = new JobModel();
                                                         $qualificationModel = new QualificationModel();
                                                         $typeModel = new TypeModel();
                                                         
                                                                                echo "<div class='row col-md-offset-8'>
                                                                                        <select onchange='myFunction()' class='form-control col-md-8' id='userfollowing' name = 'userfollowing' style='width:200px;'>
                                                                                        <option value='0'>All</option>";
                                                                                          foreach($searc as $row2)
                                                                                          { if($select == $row2->followinguserId)
                                                                                            {
                                                                                              echo '<option value='.$row2->followinguserId.' selected="selected">'.$userModel->GetUserById($row2->followinguserId)->username.'</option>';
                                                                                            }else
                                                                                            {
                                                                                                echo '<option value='.$row2->followinguserId.'>'.$userModel->GetUserById($row2->followinguserId)->username.'</option>';
                                                                                            }
                                                                                            
                                                                                          }
                                                                                       echo "</select>
                                                                                  </div>
                                                                                <script>
                                                                                function myFunction() {
                                                                                    var x = document.getElementById('userfollowing').value;
                                                                                    $('#timeline').load('updateTimeline.php?epr=view&select=' + x);

                                                                                }
                                                                                </script>";
                                                       try
                                                        {
                                                            if($searc != null)
                                                            {
                                                                foreach($searc as $row)
                                                                {
                                                                    if($Timeline != null)
                                                                    {
                                                                        foreach($Timeline as $row1)
                                                                        {
                                                                            if($row->followinguserId == $row1->userid)
                                                                            {
                                                                                $user = $userModel->GetUserById($row->followinguserId);
                                                                                $timeLineEvent = $notificationTypeModel->GetNotificationTypeById($row1->typeid)->name;
                                                                                $job = $jobModel->GetJobsByID($row1->jobid);
                                                                                $qualification = $qualificationModel->GetQualificationByID($job->qualification);
                                                                                $type = $typeModel->GetTypeByID($job->type);

                                                                                if($row1->typeid == 6)
                                                                                {
                                                                                    if($select == $row->followinguserId)
                                                                                    {
                                                                                        echo "<div class='timeline-item' id='gdsa'>"
                                                                                                . "<div class='year'><div class='col-md-7'>$row1->dateposted</div> <span class='marker'><span class='dot'></span></span>
                                                                                             </div>
                                                                                             <div class='info'>
                                                                                                 <div class='row'>
                                                                                                     <div class='tl col-md-3'>
                                                                                                             <a href='ViewUserProfile.php?epr=view&id=".$job->id."'><img src='$user->photo' class='img-responsive' alt=''></a>
                                                                                                             <div class='row col-md-3'>
                                                                                                                 <p style='text-align:center;'><strong>$user->username</strong></p>
                                                                                                             </div>
                                                                                                     </div>

                                                                                                     <div class='col-md-9'>
                                                                                                         <p style='font-size: 14px;' style='text-align:center;'><strong>$timeLineEvent:</strong></p>
                                                                                                         <div class='row col-md-offset-2'>
                                                                                                             <p><a href='SearchResult.php?epr=view&id=".$job->jobid."&typeId=".$job->type."' style='font-size: 14px; text-align:center;margin-left:10px;'><strong>$job->name</strong></a></p>
                                                                                                                 </br>
                                                                                                             <table class='sortable table' id='myJobTable'>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Qualification:</strong>&nbsp&nbsp$qualification->qualificationName</td>
                                                                                                                 </tr>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Category:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$type->name</td>
                                                                                                                 </tr>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Number Of Days:</strong>&nbsp&nbsp $job->numberOfDays </td>
                                                                                                                 </tr>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Number Of People Required:</strong>&nbsp&nbsp $job->numberOfPeopleRequired </td>
                                                                                                                 </tr>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Price / Minimum Bid:</strong>&nbsp&nbsp $job->price </td>
                                                                                                                 </tr>
                                                                                                             </table>
                                                                                                         </div>
                                                                                                     </div>

                                                                                                 </div>
                                                                                             </div></div>";
                                                                                    }else if($select == 0)
                                                                                    {
                                                                                        echo "<div class='timeline-item' id='gdsa'>"
                                                                                                . "<div class='year'><div class='col-md-7'>$row1->dateposted</div> <span class='marker'><span class='dot'></span></span>
                                                                                             </div>
                                                                                             <div class='info'>
                                                                                                 <div class='row'>
                                                                                                     <div class='tl col-md-3'>
                                                                                                             <a href='ViewUserProfile.php?epr=view&id=".$job->id."'><img src='$user->photo' class='img-responsive' alt=''></a>
                                                                                                             <div class='row col-md-3'>
                                                                                                                 <p style='text-align:center;'><strong>$user->username</strong></p>
                                                                                                             </div>
                                                                                                     </div>

                                                                                                     <div class='col-md-9'>
                                                                                                         <p style='font-size: 14px;' style='text-align:center;'><strong>$timeLineEvent:</strong></p>
                                                                                                         <div class='row col-md-offset-2'>
                                                                                                             <p><a href='SearchResult.php?epr=view&id=".$job->jobid."' style='font-size: 14px; text-align:center;margin-left:10px;'><strong>$job->name</strong></a></p>
                                                                                                                 </br>
                                                                                                             <table class='sortable table' id='myJobTable'>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Qualification:</strong>&nbsp&nbsp$qualification->qualificationName</td>
                                                                                                                 </tr>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Category:</strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$type->name</td>
                                                                                                                 </tr>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Number Of Days:</strong>&nbsp&nbsp $job->numberOfDays </td>
                                                                                                                 </tr>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Number Of People Required:</strong>&nbsp&nbsp $job->numberOfPeopleRequired </td>
                                                                                                                 </tr>
                                                                                                                 <tr>
                                                                                                                     <td><strong>Price / Minimum Bid:</strong>&nbsp&nbsp $job->price </td>
                                                                                                                 </tr>
                                                                                                             </table>
                                                                                                         </div>
                                                                                                     </div>

                                                                                                 </div>
                                                                                             </div></div>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                    }catch(Exception $x)
                                                    {
                                                        echo 'Caught exception: ',  $x->getMessage(), "\n";
                                                    }

                                                       ?>
        </div>
    </body>
</html>
