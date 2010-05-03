<h2>Bulletin Rules</h2>
<p>Students must recognize that each college has its own bulletin usage rule.
Students are responsible for knowing which bulletin they should follow.</p>
<h3>COLLEGE BULLETIN USAGE RULES</h3>
<?php foreach (new UNL_UndergraduateBulletin_CollegeList() as $college) {
    if (isset($college->description->bulletinRule)) {
        echo '<h4 class="sec_main">'.$college->name.'</h4>';
        echo $college->description->bulletinRule;
    }
}
?>