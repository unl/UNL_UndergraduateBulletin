<script type="text/javascript">
//<![CDATA[
    WDN.jQuery(document).ready(function(){
         WDN.initializePlugin('zenform');
         WDN.jQuery('#majorbox').change(function(){
             if (WDN.jQuery(this).attr('value') == 'Unknown') {
                 // Show the other box, on update, set the value of the Unknown field
            	 WDN.jQuery('#othermajor').show();
            	 WDN.jQuery('#othermajor').focus();
             } else {
            	 WDN.jQuery('#othermajor').hide();
             }
         });
         WDN.jQuery('#othermajor').change(function(){
        	 WDN.jQuery('#otherselected').val(WDN.jQuery(this).val());
         });
    });
//]]>
</script>

<div class="three_col left">
<form class="zenform" action="https://spreadsheets.google.com/formResponse?formkey=dFNEZlRfTjlsS0lrMk94YThOV0lsNUE6MQ&amp;ifq" method="POST" id="ss-form">

<fieldset>
        <legend>Program of study recruitment descriptions</legend>
        <ol>
            <li>
          This information will be used to create a recruitment paragraph to enhance prospective and current students' knowledge of UNL's academic offerings by creating a majors overview that's inviting, accurate, and informative.
          </li>
          <li>
            <input type="hidden" name="entry.10.single" value="<?php echo UNL_UndergraduateBulletin_Editor::get(); ?>" class="ss-q-short" id="entry_10" />

         <li>
          <label class="ss-q-title" for="entry_9"> <span class="required">*</span>What is the title of the area of study you&#39;re describing?</label>
          <label style="font-size:10px;" for="entry_9">Major, minor, or program name</label>
          <select name='entry.9.single' id="majorbox">
            <?php
            $majors = new UNL_UndergraduateBulletin_MajorList;
            foreach($majors as $major) {
                echo "<option value='" . htmlspecialchars($major->title, ENT_QUOTES) . "'/>" . htmlspecialchars($major->title, ENT_QUOTES) . "<br/>";
            }
            ?>
            <option value="Unknown" id="otherselected">Other Area of Study (enter name below)</option>
            </select>
            <input type="text" id="othermajor" style="display:none;" />
            </li>
			<li>
			<label class="ss-q-title" for="entry_11">Please provide a web address (URL) for this major. </label>
			<label style="font-size:10px;" for="entry_9">Use the URL of a prospective student-focused web page you have on your site.</label>
            <input name="entry.11.single" value="" class="ss-q-short" id="entry_11" type="text" />
            </li>
			<li>
			The name and contact information submitted below will be visible to prospective students on the Office of Admissions website.
			</li>
			
			<li>
			<label class="ss-q-title" for="entry_12">Name<span class="required">*</span></label>
			<input name="entry.12.single" value="" class="ss-q-short" id="entry_12" type="text" />
			</li>

			<li>
			<label class="ss-q-title" for="entry_13">Title<span class="required">*</span></label>
			<input name="entry.13.single" value="" class="ss-q-short" id="entry_13" type="text" />
			</li>
			
			<li>
			<label class="ss-q-title" for="entry_14">Email address<span class="required">*</span></label>
			<input name="entry.14.single" value="" class="ss-q-short" id="entry_14" type="text" />
			</li>

			<li>
			<label class="ss-q-title" for="entry_15">Phone number<span class="required">*</span></label>
			<input name="entry.15.single" value="" class="ss-q-short" id="entry_15" type="text" />
			</li>
			
                    <li>
          <label class="ss-q-title" for="entry_0"><span class="required">*</span>What knowledge / experience / preparation do students get from this major?</label>
          <label class="ss-q-help" for="entry_0"></label>
          <textarea name="entry.0.single" rows="8" cols="75" class="ss-q-long" id="entry_0"></textarea>
          </li>

                    <li>
          <label class="ss-q-title" for="entry_1"><span class="required">*</span>What career opportunities are associated with this major?</label>
                    <label class="ss-q-help" for="entry_1"></label>
                    <textarea name="entry.1.single" rows="8" cols="75" class="ss-q-long" id="entry_1"></textarea>
          </li>
          
                    <li><h3><strong>Program strengths</strong></h3>
                        <p>Specific program strengths that distinguish UNL from other schools. </p>
                        </li>
 
             <li>          
            <label class="ss-q-title" for="entry_8"><span class="required">*</span>How is this program different from those at Big Ten (and/or regional) schools?</label>
            <label  style="font-size:10px;" for="entry_8">Summary paragraph describing the strengths of the program, including internships, clubs, competition (awards), notable alumni/faculty, facilities, rankings, research and creative activity</label>
            <textarea name="entry.8.single" rows="8" cols="75" class="ss-q-long" id="entry_8"></textarea>
            </li>
            
                        <li>
            <label class="ss-q-title" for="entry_2">Please list notable internships, clubs, competition (awards)
</label>
            <label class="ss-q-help" for="entry_2"></label>
            <textarea name="entry.2.single" rows="8" cols="75" class="ss-q-long" id="entry_2"></textarea>
            </li>

                        <li>
            <label class="ss-q-title" for="entry_4">Please list notable alumni and/or faculty</label>
            <label class="ss-q-help" for="entry_4"></label>
            <textarea name="entry.4.single" rows="8" cols="75" class="ss-q-long" id="entry_4"></textarea>
            </li>

                        <li>
            <label class="ss-q-title" for="entry_5">Please list notable facilities</label>
            <label class="ss-q-help" for="entry_5"></label>
            <textarea name="entry.5.single" rows="8" cols="75" class="ss-q-long" id="entry_5"></textarea>
            </li>
            
                        <li>
            <label class="ss-q-title" for="entry_6">Please list notable rankings</label>
            <label class="ss-q-help" for="entry_6"></label>
            <textarea name="entry.6.single" rows="8" cols="75" class="ss-q-long" id="entry_6"></textarea>
            </li>
            
            <li>
            <label class="ss-q-title" for="entry_7">Please list notable research and creative activity</label>
            <label class="ss-q-help" for="entry_7"></label>
            <textarea name="entry.7.single" rows="8" cols="75" class="ss-q-long" id="entry_7"></textarea>
            </li>
	</ol>
          <input type="hidden" name="pageNumber" value="0" />
          <input type="hidden" name="backupCache" value="" />
          
          <input type="submit" name="submit" value="Submit" /></fieldset></form>
</div>
