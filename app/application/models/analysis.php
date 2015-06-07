<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Analysis extends CI_Model
{
 
function passPercentageReportCollege($client_id,$exam_id,$filterQry)

{

	$query = $this->db->query("select * from
	(select a.student_cnt,b.student_pass_cnt,
    ROUND((b.student_pass_cnt/a.student_cnt)*100) pass_percentage from 
    (select client_id,count(distinct student_id) student_cnt from results
    where lgcl_del_f='N' and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by client_id)a
    
    join
    (select client_id,count(distinct student_id) student_pass_cnt from results
    where marks_obtained>=pass_mark and lgcl_del_f='N' 
    and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by client_id)b
    on a.client_id=b.client_id)
	SCR ".$filterQry);

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }

}


function passPercentageReportDept($client_id,$exam_id,$filterQry)

{

	$query = $this->db->query("select * from
	(select a.dept_code,a.student_cnt,b.student_pass_cnt,
    ROUND((b.student_pass_cnt/a.student_cnt)*100) pass_percentage from 
    (select dept_code,count(distinct student_id) student_cnt from results
    where lgcl_del_f='N' and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by dept_code)a
    join
    (select dept_code,count(distinct student_id) student_pass_cnt from results
    where marks_obtained>=pass_mark and lgcl_del_f='N' 
    and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by dept_code)b
    on a.dept_code=b.dept_code)
	SCR ".$filterQry." order by pass_percentage desc");

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }

}

function passPercentageReportYear($client_id,$exam_id,$filterQry)

{

  $query = $this->db->query("select * from
  (select a.year,a.student_cnt,b.student_pass_cnt,
    ROUND((b.student_pass_cnt/a.student_cnt)*100) pass_percentage from 
    (select year,count(distinct student_id) student_cnt from results
    where lgcl_del_f='N' and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by year)a
    join
    (select year,count(distinct student_id) student_pass_cnt from results
    where marks_obtained>=pass_mark and lgcl_del_f='N' 
    and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by year)b
    on a.year=b.year)
  SCR ".$filterQry." order by pass_percentage desc");

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }

}

function passPercentageReportDeptYear($client_id,$exam_id,$filterQry)

{

  $query = $this->db->query("select * from
  (select a.dept_code,a.year,a.student_cnt,b.student_pass_cnt,
    ROUND((b.student_pass_cnt/a.student_cnt)*100) pass_percentage from 
    (select dept_code,year,count(distinct student_id) student_cnt from results
    where lgcl_del_f='N' and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by dept_code,year)a
    join
    (select dept_code,year,count(distinct student_id) student_pass_cnt from results
    where marks_obtained>=pass_mark and lgcl_del_f='N' 
    and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by dept_code,year)b
    on a.dept_code=b.dept_code and a.year=b.year)
  SCR ".$filterQry." order by pass_percentage desc");

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }

}

function passPercentageReportClass($client_id,$exam_id,$filterQry)

{

  $query = $this->db->query("select * from
  (select a.dept_code,a.year,a.section,a.student_cnt,b.student_pass_cnt,
    ROUND((b.student_pass_cnt/a.student_cnt)*100) pass_percentage from 
    (select dept_code,year,section,count(distinct student_id) student_cnt from results
    where lgcl_del_f='N' and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by dept_code,year,section)a
    join
    (select dept_code,year,section,count(distinct student_id) student_pass_cnt from results
    where marks_obtained>=pass_mark and lgcl_del_f='N' 
    and client_id=".$this->db->escape($client_id)." and exam_id=".$this->db->escape($exam_id)." group by dept_code,year,section)b
    on a.dept_code=b.dept_code and a.year=b.year)
  SCR ".$filterQry." order by pass_percentage desc");

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }

}

function topperReportCollege($client_id,$exam_id,$filterQry)

{

  $query = $this->db->query("select dept_code,year,section,student_id,student_name,percentage,rank from
(select rset.*,
( 
CASE 
WHEN percentage=@oldPercent
THEN @curRow := @curRow + 0 
ELSE @curRow := @curRow + 1 
END
)AS rank,
@oldPercent := percentage
from
(select b.*,a.percentage
from
(select student_id,AVG(marks_obtained) percentage
from results
where lgcl_del_f='N' and exam_id=".$this->db->escape($exam_id)." and client_id=".$this->db->escape($client_id)." and marks_obtained>=pass_mark
group by student_id)a
join
(select distinct client_id,dept_code,year,section,student_id,student_name
from results
where lgcl_del_f='N' and exam_id=".$this->db->escape($exam_id)." and client_id=".$this->db->escape($client_id)." and marks_obtained>=pass_mark)b
on a.student_id=b.student_id)
rset,
(SELECT @curRow := 0, @oldPercent := 0) r
order by percentage desc
)SCR ".$filterQry);

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }

}

function topperReportDept($client_id,$exam_id,$filterQry)

{

  $query = $this->db->query("select dept_code,year,section,student_id,student_name,percentage,rank from
(select rset.*,
( 
CASE 
WHEN dept_code = @dept and percentage=@oldPercent
THEN @curRow := @curRow + 0 
WHEN dept_code = @dept and percentage<>@oldPercent
THEN @curRow := @curRow + 1 
ELSE @curRow := 1 AND @dept := dept_code END
) + 1 AS rank,@oldPercent := percentage
from
(select b.*,a.percentage
from
(select student_id,AVG(marks_obtained) percentage
from results
where lgcl_del_f='N' and exam_id=".$this->db->escape($exam_id)." and client_id=".$this->db->escape($client_id)." and marks_obtained>=pass_mark
group by student_id)a
join
(select distinct client_id,dept_code,year,section,student_id,student_name
from results
where lgcl_del_f='N' and exam_id=".$this->db->escape($exam_id)." and client_id=".$this->db->escape($client_id)." and marks_obtained>=pass_mark)b
on a.student_id=b.student_id)rset,
(SELECT @curRow := 0, @oldPercent := 0, @client_id := 0, @dept := '', @year := 0, @section='') r
order by dept_code,percentage desc
)SCR ".$filterQry." order by dept_code");

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }

}

function topperReportYear($client_id,$exam_id,$filterQry)

{

  $query = $this->db->query("select dept_code,year,section,student_id,student_name,percentage,rank from
(select rset.*,
( 
CASE 
WHEN year = @year and percentage=@oldPercent
THEN @curRow := @curRow + 0 
WHEN year = @year and percentage<>@oldPercent
THEN @curRow := @curRow + 1 
ELSE @curRow := 1 AND @year := year END
) AS rank,@oldPercent := percentage
from
(select b.*,a.percentage
from
(select student_id,AVG(marks_obtained) percentage
from results
where lgcl_del_f='N' and exam_id=".$this->db->escape($exam_id)." and client_id=".$this->db->escape($client_id)." and marks_obtained>=pass_mark
group by student_id)a
join
(select distinct client_id,dept_code,year,section,student_id,student_name
from results
where lgcl_del_f='N' and exam_id=".$this->db->escape($exam_id)." and client_id=".$this->db->escape($client_id)." and marks_obtained>=pass_mark)b
on a.student_id=b.student_id)rset,
(SELECT @curRow := 0, @oldPercent := 0, @client_id := 0, @dept := '', @year := 0, @section :='') r
order by year,percentage desc
)SCR ".$filterQry." order by year");

   if($query -> num_rows() >= 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }

}


}
?>