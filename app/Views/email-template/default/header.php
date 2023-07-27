<?php

    use NH\APP\HELPERS\Nh_Hooks;

    /**
     * @Filename: header.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     */
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>NH</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <style>
            p {
                font-family: 'Roboto', sans-serif;
                font-size: 16px;
                margin-bottom: 37px;
                margin-top: 0;
                line-height: 24px;
            }

            body {
                margin: 0;
            }

            header {
                background-color: black;
                display: flex;
                align-items: center;
                justify-content: center;
                max-width: 600px;
                margin: auto;
            }

            header img {
                height: 50px;
                padding: 20px 0;
                margin: auto;
            }

            .custom_container .content {
                padding: 0 35px;
                padding-top: 50px;
            }

            .custom_container .content p span {
                color: #FF3131;
                text-decoration: line-through;
            }

            .custom_container {
                max-width: 600px;
                margin: auto;
                border: 1px solid #eee;
                border-top: 0;
                margin-bottom: 50px;
            }

            .custom_container .head img {
                width: 100%;
            }

            .cobyright p {
                font-size: 11px;
                width: 100%;
                text-align: center;
                margin-bottom: 17px;
            }
        </style>
    </head>

    <body>