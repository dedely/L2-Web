<?php
    $title = "Region selection test";
    include "include/header.inc.php";
?>

        <h1>Region</h1>
        <section>
            <h2>Region form</h2>
            <form method="GET" action="dpt.php">
                <fieldset>
                    <legend> simple form </legend>
                    <label for="regionCodeField">Type a region code</label>
                    <input type="text" name="regionCode" id="regionCodeField" size="10" />
                    <input type="submit" value="Go!"/>
                </fieldset>
            </form>
        </section>

<?php require_once "include/footer.inc.php"; ?>