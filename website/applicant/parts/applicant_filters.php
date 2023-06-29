<!--Filter -->
<form method="post">
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">Filter Jobs</p>
            <button type="button" class="card-header-icon" aria-label="more options" onclick="hide_show_something('filters')">
                <span class="icon">
                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
            </button>
        </header>
        <div class="card" id="filters" style="display: block;">
            <div class="card-content">
                <div class="content">
                    <div class="columns">
                        <div class="column is-3">
                            <input class="input is-dark" type="text" name="jobtitle" placeholder="Job">
                        </div>
                        <div class="column is-2">
                            <input class="input is-dark" type="place" name="cityname" placeholder="Place">
                        </div>
                        <div class="column is-5"></div>
                    </div>
                    <div class="columns">
                        <div class="column is-2">
                            <div class="field">
                                <label class="label">Industry</label>
                                <div class="control">
                                    <div class="select is-dark"><!-- Dropdown select for industries-->
                                        <select name="industry">
                                            <?php
                                            $data = Applicant::getIndustry_Data();
                                            echo '<option>--All--</option>';
                                            foreach($data as $item)
                                            {
                                                echo '<option value="'.$item[1].'">'.$item[1].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-2">
                            <div class="field">
                                <label class="label">Company</label>
                                <div class="control">
                                    <div class="select is-dark">
                                        <select name="companyname">
                                            <?php
                                            $data = Company::getCompany_Data();
                                            echo '<option>--All--</option>';
                                            foreach ($data as $item)
                                            {
                                                echo '<option value="'.$item[1].'">'.$item[1].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-1">
                            <label class="label" for="salaryfrom">Salary from</label>
                            <input class="input is-dark" name="salaryfrom" type="number" min="500" placeholder="€">
                        </div>
                        <div class="column is-1">
                            <label class="label" for="salaryto" hidden>to</label>
                            <input class="input is-dark" name="salaryto" type="number" placeholder="€ ">
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-4">
                            <div class="buttons">
                                <button class="button is-dark is-rounded" name="filter">Save</button>
                                <button class="button is-light">Reset filters</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form><?php
