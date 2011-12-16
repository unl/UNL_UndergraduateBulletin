<div id="search_forms">
    <h3 id="search_label">Find a <span class="option selected" id="course">Course</span> or find a <span class="option" id="major">Major/Degree</span>
    </h3>
    <?php
    echo $savvy->render('', 'CourseSearchForm.tpl.php');
    echo $savvy->render('', 'MajorList/SearchForm.tpl.php');
    ?>
</div>