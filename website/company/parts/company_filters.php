<?php

    if (isset($_POST["filters"])) {

        $prefill_employee = $_POST["employee"];
        $prefill_place = $_POST["place"];

        if($_POST["industry"] == "--Alle--") {
            $prefill_industry_id = null;
        } else {
            $prefill_industry_id = $_POST["industry"];
        }

        if($_POST["education"] == "--Alle--") {
            $prefill_education_id = null;
        } else {
            $prefill_education_id = $_POST["education"];
        }

    } else {

        $prefill_employee = null;
        $prefill_place = null;
        $prefill_industry_id = null;
        $prefill_education_id = null;

    }

?>

<!--Filter -->
<form method="post">
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">Filter Applicants</p>
            <button class="card-header-icon toggleFilter" type="button" aria-label="more options" onclick="hide_show_something('filter')" >
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
            </button>
        </header>
        <div class="card test filter" id="filter">
            <div class="card-content">
                <div class="content">
                    <div class="columns">
                        <div class="column is-2">
                            <input class="input" type="text" placeholder="Name" name="employee" <?php if(!is_null($prefill_employee)) { echo 'value="' . $prefill_employee . '"'; } ?>>
                        </div>
                        <div class="column is-2">
                            <input class="input" type="text" placeholder="Ort" name="place" <?php if(!is_null($prefill_place)) { echo 'value="' . $prefill_place . '"'; } ?>>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-2">
                            <div class="field">
                                <label class="label">Fachbereich</label>
                                <div class="control">
                                    <div class="select"><!-- Dropdown select for industries-->
                                        <select name="industry">
                                            <?php
                                                $data = Applicant::getIndustry_Data();

                                                echo '<option>--Alle--</option>';

                                                foreach($data as $item) {

                                                    if (!is_null($prefill_industry_id) && $prefill_industry_id == $item[0]) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }

                                                    echo '<option value="'.$item[0].'"' . $selected . '>'.$item[1].'</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="field">
                                <label for="education" class="label">Abschluss/Ausbildung</label>
                                <div class="control">
                                    <div class="select"><!-- Dropdown select for industries-->
                                        <select name="education">
                                            <?php
                                                $data = Applicant::getEducation_Data();

                                                echo '<option>--Alle--</option>';

                                                foreach($data as $item) {

                                                    if (!is_null($prefill_education_id) && $prefill_education_id == $item[0]) {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }

                                                    echo '<option value="'.$item[0].'"' . $selected . '>'.$item[1].'</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-4">
                            <div class="buttons">
                                <button class="button is-dark is-rounded" name="filters">Speichern</button>
                                <button class="button is-outlined-light">Filter zurücksetzen</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</form>