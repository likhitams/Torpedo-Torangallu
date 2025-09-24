<!DOCTYPE html>
<html>

<head>
  <title></title>
</head>

<body>
  <div class="taphole">

    <table class="table table-taphole">
      <tr>
        <!-- <th colspan="4" class="text-center" style="background-color: cyan;">Phase I & II Taphole details</th> -->

      </tr>
      <tr>
        <th colspan="4" class="text-center">Production rate(T/Hr)</th>
      </tr>
      <tr>
        <td colspan="2" class="text-center">BF1</td>
        <td><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE SOURCE='BF1' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
            echo $bf[0]->BF_PROD; ?></td>
      </tr>
      <tr>
        <td colspan="2" class="text-center">BF2</td>
        <td><?php $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE SOURCE='BF2' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
            echo $bf[0]->BF_PROD; ?></td>
      </tr>
      <tr>
        <th colspan="4" class="text-center">Consumption rate(T/Hr)</th>
      </tr>
      <tr>
        <td colspan="2" class="text-center">SMS1</td>
        <td><?php
            $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF1SMS1','BF1') AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
            $res_bf = $bf[0]->BF_PROD;
            $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
            $res_tot = $tot[0]->NET_WEIGHT;

            $result_sms = $res_bf - $res_tot;
            echo $result_sms;
            ?></td>
      </tr>
      <tr>
        <td colspan="2" class="text-center">SMS2</td>
        <td><?php
            $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE DEST IN ('BF2SMS1','BF2') AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
            $res_bf = $bf[0]->BF_PROD;
            $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
            $res_tot = $tot[0]->NET_WEIGHT;

            $result_sms = $res_bf - $res_tot;
            echo $result_sms;
            ?></td>
      </tr>
      <tr>
        <th colspan="4" class="text-center">Load Status</th>
      </tr>
      <tr>
        <td>WB I</td>
        <td>TIC no-<?php
                    $bf = ($this->master_db->runQuerySql("SELECT count(ladleid)  BF_PROD   FROM laddle_report WHERE WB_NO='1' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                    $res_bf = $bf[0]->BF_PROD;
                    $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                    $res_tot = $tot[0]->NET_WEIGHT;

                    $result_sms = $res_bf - $res_tot;
                    echo $result_sms;
                    ?></td>
        <td>Tons-<?php
                  $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE WB_NO='1' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                  $res_bf = $bf[0]->BF_PROD;
                  $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                  $res_tot = $tot[0]->NET_WEIGHT;

                  $result_sms = $res_bf - $res_tot;
                  echo $result_sms;
                  ?></td>
      </tr>
      <tr>
        <td>WB II </td>
        <td>TIC no-<?php
                    $bf = ($this->master_db->runQuerySql("SELECT count(ladleid)  BF_PROD   FROM laddle_report WHERE WB_NO='2' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                    $res_bf = $bf[0]->BF_PROD;
                    $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                    $res_tot = $tot[0]->NET_WEIGHT;

                    $result_sms = $res_bf - $res_tot;
                    echo $result_sms;
                    ?></td>
        <td>Tons-<?php
                  $bf = ($this->master_db->runQuerySql("SELECT SUM(NET_WEIGHT)  BF_PROD   FROM laddle_report WHERE WB_NO='2' AND GROSS_DATE>=CONCAT(DATE_SUB(CURRENT_DATE , INTERVAL 1 DAY),' ','22:00:00')  "));
                  $res_bf = $bf[0]->BF_PROD;
                  $tot = $this->master_db->runQuerySql("select SUM(NET_WEIGHT) NET_WEIGHT from ladle_master where LOAD_STATUS IN (202,205) and cycle=1 and companyid = 95 ");
                  $res_tot = $tot[0]->NET_WEIGHT;

                  $result_sms = $res_bf - $res_tot;
                  echo $result_sms;
                  ?>


        </td>
      </tr>


    </table>
  </div>
</body>

</html>