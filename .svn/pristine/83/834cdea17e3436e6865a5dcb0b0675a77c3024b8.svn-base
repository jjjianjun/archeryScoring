<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<TITLE>form_e-Aduan</TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-1">
<script language = "Javascript">
function klikOther(frm) {
	if (frm.elements["checkbox14"].checked == true) {
		frm.elements["aduan"].disabled = false;
	}
	else {
		frm.elements["aduan"].disabled = true;
	}
}
function ValidateForm(dml,chkName){
len = dml.elements.length;
var i=0;
for( i=0 ; i<len ; i++) {
if ((dml.elements[i].name==chkName) && (dml.elements[i].checked==1)) return true
}
alert("Please select at least one record to be deleted")
return false;
}
</script>

<body background="image/logo.gif">
<form name="frm" align="center"  method="POST" onSubmit="return ValidateForm()">
 
    

    <p align="center">&nbsp;</p>
    
  <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>BORANG 
    ADUAN KEROSAKKAN PERALATAN ICT</strong></font></p>
    
  <div id="Layer6" style="position:absolute; width:593px; height:12px; z-index:6; left: 11px; top: 95px; background-color: #CC99FF; layer-background-color: #CC99FF; border: 1px none #000000;"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>MAKLUMAT 
    PENGADU</strong></font> </div>
  <div id="Layer6" style="position:absolute; width:620px; height:12px; z-index:6; left: 11px; top: 376px; background-color: #CC99FF; layer-background-color: #CC99FF; border: 1px none #000000;"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>KETERANGAN
        PENGADU</strong></font> </div>
  <p>&nbsp;</p>
    <p><font size="2"><font face="Arial, Helvetica, sans-serif"><strong>NAMA PENGADU</strong></font><strong> 
      :</strong> 
        <input name="nama_pelapor" type="text" id="nama_pelapor" size="70" >
    </font></p>
  <p><font size="2"><font face="Arial, Helvetica, sans-serif"><strong>LOKASI</strong></font><strong> 
    :<font size="2" face="Arial, Helvetica, sans-serif"> 
    <select name="lokasi" id="lokasi">
      <option value="0">-Pilih Bahagian Anda-</option>
      <option value="Bhgn. Perkhidmatan Maklumat">2 - Bhgn. Perkhidmatan Maklumat</option>
      <option value="Bhgn. Jurnal dan Pangkalan Data">5 - Bhgn. Jurnal dan Pangkalan
      Data</option>
      <option value="Bhgn. Pembangunan Sumber ILMU">6 - Bhgn. Pembangunan Sumber
      ILMU</option>
      <option value="Bhgn. Pentadbiran">7 - Bhgn. Pentadbiran</option>
      <option value="Perpustakaan Hospital Selayang">8 - Perpustakaan Hospital
      Selayang</option>
      <option value="Perpustakaan INTEC">9 - Perpustakaan INTEC</option>
      <option value="Perpustakaan FSPU">10 - Perpustakaan FSPU</option>
      <option value="Perpustakaan JO">11 - Perpustakaan Jalan Othman</option>
      <option value="Perpustakaan PP">12 - Perpustakaan Puncak Perdana</option>
      <option value="PTAR 2">13 - PTAR 2</option>
      <option value="PTAR 3">14 - PTAR 3</option>
      <option value="PTAR 4">15 - PTAR 4</option>
      <option value="Unit Pengurusan Kualiti">16 - Unit Pengurusan Kualiti</option>
      <option value="Unit Kualiti">17 - Unit Kualiti</option>
      <option value="Unit Latihan">18 - Unit Latihan</option>
    </select>
</font><font size="2"><font size="2" face="Arial, Helvetica, sans-serif">
<input name="tarikhhariini" type="hidden" id="tarikhhariini" value="<? echo date("d/m/Y H:m:s")?>">
</font></font><font size="2" face="Arial, Helvetica, sans-serif">    </font></strong></font><font size="2" face="Arial, Helvetica, sans-serif">
    </font></p>
  <p align="left"><font size="2"><font size="2"><font size="2"><font size="2"><font size="2"> 
    </font></font> <font face="Arial, Helvetica, sans-serif"><strong> STAFF 
      ID </strong></font><strong>:
      </strong><font size="2"><font size="2"><strong>
      <input name="no_staff" type="text" id="no_staff2">
      </strong></font></font><strong>      </strong><font size="2">      <font size="2"><font size="2"><font face="Arial, Helvetica, sans-serif"><strong>NO
      TEL</strong></font><strong>:</strong><font size="2">
      <input name="no_tel" type="text" id="no_tel">
  </font></font></font> </font></font></font></font></p>
    
  <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>EMAIL 
    :</strong></font><font size="2"> 
    <input name="email" type="text" id="email" size="70">
    </font></p>
  <p align="left">Kerosakkan pertama :
    <input name="kerosakan _pertama" type="text" id="kerosakan _pertama">
  </p>
  <p align="left">&nbsp;</p>
  <p>&nbsp;</p>
  <p><strong>Jenis Kerosakan :</strong>Sila pilih kerosakan yang berkenaan.</p>
  <p>
    <select name="laporan" id="laporan">
    <option selected>- Sila Pilih Kerosakkan -</option>
    <option>CPU</option>
    <option>OS (Windows)</option>
    <option>Mouse</option>
    <option>Monitor</option>
    <option>Floppy Drive</option>
    <option>Keyboard</option>
    <option>Printer</option>
    <option>AVR</option>
    <option>Software</option>
    <option>Power Supply</option>
    <option>Virus Attack</option>
    <option>Network</option>
    <option>CD-Rom Drive</option>
    </select>
  </p>
  <table width="13%" border="0" id="others">
    <tr>
      <td height="17"><font size="2">
        <input type="checkbox" name="checkbox14" value="checkbox" onClick="klikOther(this.form);">
      Others</font></td>
    </tr>
  </table>
  <p align="left"> 
    <textarea name="aduan" cols="40" rows="7" disabled="true" id="aduan" ></textarea>
  </p>
  <p align="left">&nbsp;</p>
  <p> 
    <input type="submit" name="Submit" value="Hantar Aduan">
    <input type="reset" name="Submit2" value="Kosongkan">
  </p>
  
</form>

</body>
</html>
