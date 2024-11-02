<?php
include_once '../../include/header.php';
//print_r($_SESSION);

$pageIndex=0;
$pageSize=4;

//print_r($_POST);
if(isset($_GET['pageIndex']) && !empty($_GET['pageIndex']))
{
	$pageIndex=$_REQUEST['pageIndex'];	
}
else
{
	$pageIndex=0;	
}
if(isset($_POST['smtRight']))
{
	$pageIndex += (1*$pageSize);
	header('location:?pageIndex='.$pageIndex);	
}
else if(isset($_POST['smtLeft']))
{
	$pageIndex -= (1*$pageSize);
	header('location:?pageIndex='.$pageIndex);	
}
if(isset($_POST['txtSearch']) && !empty($_POST['txtSearch']))
{
	$search=$_POST['txtSearch'];
	header('location:?pageIndex=0&action=search&text='.$search);	
}
if(isset($_GET['action']) && $_GET['action']=="search")
{
	$search=trim(addslashes($_GET['text']));
}
else
{
	$search="";
}
if($pageIndex<0) $pageIndex=0;
$countQuery="select * from tbluser a inner join tblcandidate b on a.usrId=b.cndId where concat(cndFirstName,' ',cndLastName,cndId) like '%".$search."%' and a.usrType !='admin'";
$countResult=mysql_query($countQuery);
$totalCount=mysql_num_rows($countResult);


$left="";
$right="";

$query="select * from tbluser a inner join tblcandidate b on a.usrId=b.cndId where concat(cndFirstName,' ',cndLastName,cndId) like '%".$search."%' and a.usrType!='admin' limit ".$pageIndex.",".$pageSize;
$result=mysql_query($query) or die(mysql_error());
$countMessage="";
if($result)
{
	//echo $pageSize;
	//echo $totalCount;
	$countMessage="page".($pageIndex+1)."shows".mysql_num_rows($result)."record(s) out of ".$totalCount;
	if($totalCount==0 || $pageSize>= $totalCount)
	{
		$left='disabled="disabled"';
		$right='disabled="disabled"';	
	}	
	else if($pageIndex==0)
	{
		$left='disabled="disabled"';	
	}
	else if(($pageIndex+1)*$pageSize>=$totalCount)
	{
		$left="";
		$right='disabled="disabled"';	
	}
	else
	{
		$left="";
		$right="";	
	}
if(isset($_GET['opt']) && isset($_GET['uid']))
{
	
	$opt=$_GET['opt'];
	if($opt=="status")
	{
		$queryStatus="update tbluser set usrStatus=if(usrStatus='active','inactive','active') where usrId='".$_GET['uid']."'";
		$status=mysql_query($queryStatus);
		header('location:manageCandidate.php?pageIndex='.$_GET['pageIndex']);
	}	
}
}
?>
<script type="text/javascript">
function frmManageCandidates_submit()
{
	document.frmSearchCandidates.submit();	
}
</script>
<div class="content" style="height:370px">
	<h4 class="pageHeader">Manage Candidates</h4>
	
	<div id="manage_candidates" class="list_content">
		<fieldset>
		<form method="post" name="frmSearchCandidates">
		<ul class="search">
			<li><input type="text" name="txtSearch" value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" placeholder="search.." /></li>
			<li><a onclick="return frmManageCandidates_submit()"> <img src="<?php echo URL?>images/search.png" /> </a></li>
		</ul>
		</form>
		<div style="clear:both"></div>
		<form name="frmManageCandidates" method="post">
		<table>
			<tr>
				<th>#</th>
				<th>ID</th>
				<th>Name</th>
				<th>Gender</th>
				<th>Mobile</th>
				<th>Email Id</th>
				<th>Status</th>
			</tr>
			<?php 
			$class="odd";
			 if(isset($_GET['pageIndex'])) $rownum=$_GET['pageIndex'];
			 else $rownum=0;
			//print_r($result);
		 while($row=mysql_fetch_assoc($result))
		 {			// print_r($row);
			++$rownum;		 
		 if($class=="even") $class="odd";
		 else $class="even";
		 
		 if($row['usrStatus']=="active") $status="enabled.png";
		 else $status="disabled.png";
		 
		 ?>
			<tr class="<?php echo $class?>">
				<td><?php echo $rownum?></td>
				<td><?php echo $row['usrId']?></td>
				<td><?php echo $row['cndFirstName']." ".$row['cndLastName']?></td>
				<td><?php echo $row['cndGender']?></td>
				<td><?php echo $row['cndMobilePrimary']?></td>
				<td><?php echo $row['cndEmailOfficial']?></td>
				<td><a href="?pageIndex=<?php echo isset($_GET['pageIndex'])?$_GET['pageIndex']:""?>&opt=status&uid=<?php echo $row['usrId']?>"><img class="button" src="<?php echo URL?>images/<?php echo $status?>" /></a></td>
			</tr>
			<?php }
			$count=mysql_num_rows($result);
					if($count==0)
					{?>
					<tr>
						<td class="odd" align="center" colspan="7">No Record found</td>
					</tr>	
				<?php	}
		 ?>
		</table>
		<ul class="bottom_options">
			<p><li><input type="submit" value="&lt&lt" name="smtLeft" <?php if(isset($left)) echo $left?> />

			<input type="submit" value="&gt&gt" name="smtRight" <?php if(isset($right)) echo $right?> /></li></p>
		</ul>
	</form>
	</fieldset>
	</div>
</div>
<?php 

include_once'../../include/footer.php';
?>