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
                            <input class="input" type="text" placeholder="Name" name="employee">
                        </div>
                        <div class="column is-2">
                            <input class="input" type="text" placeholder="Ort" name="place">
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
                                            foreach($data as $item)
                                            {
                                                echo '<option value="'.$item[0].'">'.$item[1].'</option>';
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
                                            foreach($data as $item)
                                            {
                                                echo '<option value="'.$item[0].'">'.$item[1].'</option>';
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
                                <button class="button is-light">Filter zurücksetzen</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</form>