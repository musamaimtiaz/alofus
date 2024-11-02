<!DOCTYPE html>
<html lang="en">

<head>
    <title>Database Upgrade Required</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .wrapper {
            background: #ffffff;
            border: 1px solid #e4e4e4;
            border-radius: 8px;
            padding: 40px;
            width: 600px;
            text-align: center;
        }

        .card-title {
            font-size: 1.5rem;
            color: #ff5757;
            margin-bottom: 20px;
        }

        .text-bold {
            font-weight: bold;
        }

        .upgrade-now-btn {
            background-color: #19c37d;
            border: none;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .note {
            color: #636363;
            font-size: 0.875rem;
            margin-top: 20px;
        }

        .backup-note {
            color: #d56e0c;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card-title">Database Upgrade Required!</div>

        <p>Prior to proceeding, it is imperative to conduct a database upgrade. The current file version stands at <b><?php echo martvillVersion()  ?></b>, whereas the database version is <b><?php echo preference('db_version', '1.0.0') ?></b>.</p>

        <p class="backup-note">Please ensure that you have created a backup of your database before initiating the upgrade process.</p>

        <form action="<?php echo url('/'); ?>" id="upgrade-db-form" method="get" accept-charset="utf-8">
            <input type="hidden" name="is_upgrade" value="true">
            <button type="submit" id="submit-btn" onclick="upgradeDB();" class="upgrade-now-btn">Upgrade Now</button>
        </form>

        <p class="note">This message might be displayed if you've uploaded files from a more recent version obtained from CodeCanyon into your current installation or if you utilized an automatic upgrade tool.</p>
    </div>

    <script>
        function upgradeDB() {
            var submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = "Please wait...";
            document.getElementById("upgrade-db-form").submit();
        }
    </script>
</body>

</html>
