<html>
<head>


    <title>Update</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            vertical-align: baseline;
            min-height: 100%;
            width: 100%;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            font-weight: 400;
            color: #444;
            font-size: 16px;
        }

        h1, h2, h3, h4, h5, h6, p, ul, span, li, input, button {
            margin: 0;
            padding: 0;
            line-height: 1.4;
            box-sizing: border-box;
        }

        span {
            line-height: inherit;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: inherit;
            font-family: 'Noto Sans HK', sans-serif;
        }

        p {
            line-height: 1.8;
            font-size: 1em;
            font-weight: 400;
            color: #112211;
        }

        h1 {
            font-size: 3.5em;
        }

        h2 {
            font-size: 2.5em;
        }

        h3 {
            font-size: 1.8em;
        }

        h4 {
            font-size: 1.3em;
        }

        h5 {
            font-size: 1.1em;
        }

        h6 {
            font-size: .95em;
            letter-spacing: 1px;
            line-height: 1.6;
        }

        strong {
            font-weight: 700;
        }

        b {
            display: inline-block;
            font-weight: 500;
        }

        li {
            display: block;
            list-style: none;
            font-size: 1em;
        }

        i, span {
            display: inline-block;
        }

        input {
            line-height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 0 15px;
        }

        button {
            outline: 0;
            border: 0;
            cursor: pointer;
        }

        .btn {
            font-weight: 500;
            display: inline-block;
            border-radius: 5px;
            text-decoration: none;
            padding: 12.5px 40px;
            background: #486FF0;
            color: #fff !important;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
        }


        .container .form-wrapper {

            max-width: 600px;
            margin: 15px auto 0;
            border-radius: 5px;
            padding: 30px 25px;
            border: 1px solid #ddd;
        }

        form .input-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        form .input-wrapper label {
            font-size: .9rem;
            width: 150px;
        }

        .mb-15{
            margin-bottom: 15px;
        }

        form .input-wrapper input {
            flex-grow: 1;
        }

        .error-container {
            font-size: .9rem;
            margin-bottom: 20px;
            display: none;
        }

        .error-container.show {
            display: block;
        }





        .error-container .title {
            margin-bottom: 10px;
        }

        .error-container ul {
            padding: 10px 15px;
            border-radius: 5px;
            border: 1px solid rgba(255, 3, 3, .2);
            background: rgba(255, 3, 3, .1);
        }

        .error-container ul li {
            margin: 5px 0;

        }

        .success-container {
            padding: 15px;
            border-radius: 5px;
            border: 1px solid rgba(38, 151, 69, .2);
            background: rgba(38, 151, 69, .1);
            display: none;
        }

        .success-container.show {
            display: block;
        }

        #container.success #install-form {
            margin-top: 15px;
            display: none;

        }

        #container #install-form {
            position: relative;
        }

        #container.loading #install-form:after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, .5);
            z-index: 1;
        }

        #container.loading .spinner {
            display: block;
        }

        .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            height: 100px;
            width: 100px;
            margin: -50px 0 0 -50px;
            display: none;
        }

        .spinner div {
            margin: 0;
        }

        .ytp-spinner {
            position: absolute;
            width: 64px;
            margin-left: -32px;
            z-index: 18;
            pointer-events: none;
        }

        .spinner .ytp-spinner-container {
            pointer-events: none;
            position: absolute;
            width: 100%;
            padding-bottom: 100%;
            top: 50%;
            left: 50%;
            margin-top: -50px;
            margin-left: -50px;
            animation: ytp-spinner-linspin 1568.23529647ms linear infinite;
            -webkit-animation: ytp-spinner-linspin 1568.23529647ms linear infinite;
        }

        .spinner .ytp-spinner-rotator {
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-animation: ytp-spinner-easespin 5332ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
            animation: ytp-spinner-easespin 5332ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
        }

        .ytp-spinner-left {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            overflow: hidden;
        }

        .ytp-spinner-right {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
        }

        .ytp-spinner-left {
            right: 49%;
        }

        .ytp-spinner-right {
            left: 49%;
        }

        .ytp-spinner-circle {
            box-sizing: border-box;
            position: absolute;
            width: 200%;
            height: 100%;
            border-style: solid;
            border-color: #486FF0 #486FF0 transparent;
            border-radius: 50%;
            border-width: 4px;
        }

        .ytp-spinner-left .ytp-spinner-circle {
            left: 0;
            right: -100%;
            border-right-color: transparent;
            -webkit-animation: ytp-spinner-left-spin 1333ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
            animation: ytp-spinner-left-spin 1333ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
        }

        .ytp-spinner-right .ytp-spinner-circle {
            left: -100%;
            right: 0;
            border-left-color: transparent;
            -webkit-animation: ytp-right-spin 1333ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
            animation: ytp-right-spin 1333ms cubic-bezier(0.4, 0.0, 0.2, 1) infinite both;
        }

        @-webkit-keyframes ytp-spinner-linspin {
            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes ytp-spinner-linspin {
            to {
                transform: rotate(360deg);
            }
        }

        @-webkit-keyframes ytp-spinner-easespin {
            12.5% {
                -webkit-transform: rotate(135deg);
            }
            25% {
                -webkit-transform: rotate(270deg);
            }
            37.5% {
                -webkit-transform: rotate(405deg);
            }
            50% {
                -webkit-transform: rotate(540deg);
            }
            62.5% {
                -webkit-transform: rotate(675deg);
            }
            75% {
                -webkit-transform: rotate(810deg);
            }
            87.5% {
                -webkit-transform: rotate(945deg);
            }
            to {
                -webkit-transform: rotate(1080deg);
            }
        }

        @keyframes ytp-spinner-easespin {
            12.5% {
                transform: rotate(135deg);
            }
            25% {
                transform: rotate(270deg);
            }
            37.5% {
                transform: rotate(405deg);
            }
            50% {
                transform: rotate(540deg);
            }
            62.5% {
                transform: rotate(675deg);
            }
            75% {
                transform: rotate(810deg);
            }
            87.5% {
                transform: rotate(945deg);
            }
            to {
                transform: rotate(1080deg);
            }
        }

        @-webkit-keyframes ytp-spinner-left-spin {
            0% {
                -webkit-transform: rotate(130deg);
            }
            50% {
                -webkit-transform: rotate(-5deg);
            }
            to {
                -webkit-transform: rotate(130deg);
            }
        }

        @keyframes ytp-spinner-left-spin {
            0% {
                transform: rotate(130deg);
            }
            50% {
                transform: rotate(-5deg);
            }
            to {
                transform: rotate(130deg);
            }
        }

        @-webkit-keyframes ytp-right-spin {
            0% {
                -webkit-transform: rotate(-130deg);
            }
            50% {
                -webkit-transform: rotate(5deg);
            }
            to {
                -webkit-transform: rotate(-130deg);
            }
        }

        @keyframes ytp-right-spin {
            0% {
                transform: rotate(-130deg);
            }
            50% {
                transform: rotate(5deg);
            }
            to {
                transform: rotate(-130deg);
            }
        }


        .loading-dot {
            color: #333;
            font: 300 1.4em/100% "Calibri";
            font-weight: 700;
        }

        .loading-dot:after {
            content: " .";
            animation: dots 1s steps(5, end) infinite;
        }

        @keyframes dots {
            0%,
            20% {
                color: rgba(0, 0, 0, 0);
                text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
            }
            40% {
                color: #333;
                text-shadow: 0.25em 0 0 rgba(0, 0, 0, 0), 0.5em 0 0 rgba(0, 0, 0, 0);
            }
            60% {
                text-shadow: 0.25em 0 0 #333, 0.5em 0 0 rgba(0, 0, 0, 0);
            }
            80%,
            100% {
                text-shadow: 0.25em 0 0 #333, 0.5em 0 0 #333;
            }
        }

    </style>


</head>
<body>


<div class="container" id="container">

    <div id="migrating-container" class="success-container">
        <p class="loading-dot">
            <b id="update-msg">{{__('lang.update_env')}}</b>
        </p>
        <p>{{__('lang.a_while')}}</p>
    </div>


    <div class="form-wrapper">

        <div class="error-container">
            <h6 class="title"><b>{{__('lang.error_occurred')}}</b></h6>

            <ul id="errors"></ul>
        </div>

        <div class="success-container" id="success-container">
            <p class="title"><b>{{__('lang.updated_your')}}</b></p>
            <p>{{__('lang.redirecting_in')}} <b id="counter">0</b> {{__('lang.seconds')}}</p>
        </div>

        <div id="install-form">
            <p class="mb-15"><b>{{__('lang.update_msg')}}</b></p>

            <button class="btn" id="update">{{__('lang.update')}}
                <b id="version-elem">{{__('lang.default_version')}}</b></button>
        </div>




    </div>


</div>

<script>

    async function getData(url = "") {

        try {

            const response = await fetch(url, {
                method: "GET",
                mode: "no-cors",
                cache: "no-cache",
                Connection: "keep-alive",
                credentials: "same-origin",
                headers: {
                    'Accept': 'application/json',
                },
                redirect: "follow",
                referrerPolicy: "no-referrer",
            });

            return response.json();
        } catch (e) {
            console.log(e)
        }


    }


    async function postData(url = "", data = {}, method = "POST") {

        try {
            let body = {}

            if (method === "POST") {
                body = {
                    body: JSON.stringify(data)
                }
            }


            const response = await fetch(url,
                {
                    ...body,
                    ...{
                        method: method,
                        mode: "cors",
                        cache: "no-cache",
                        credentials: "same-origin",
                        headers: {
                            "Content-Type": "application/json",
                            // 'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        redirect: "follow",
                        referrerPolicy: "no-referrer",
                    }
                }
            );

            return response.json();
        } catch (e) {
            console.log(e)
        }


    }



    if (document.readyState !== 'loading') {


       initFn();

    } else {
        document.addEventListener('DOMContentLoaded', async function () {

            await initFn();

        });
    }


    async function initFn(){


        const versionElem = document.getElementById("version-elem");
        const updateBtn = document.getElementById("update");
        const successContainer = document.querySelector('#success-container');
        const migratingContainer = document.querySelector('#migrating-container');
        const errorContainer = document.querySelector('.error-container');
        const errorsElem = document.querySelector('#errors');
        const containerElem = document.querySelector('#container');
        const counterElem = document.querySelector('#counter');
        const updateMsg = document.querySelector('#update-msg');


        const updateLog = await getData("/api/read-update-log");

        if(updateLog.status === 200){
            versionElem.innerText = updateLog.data;
        } else {
            console.log(updateLog)
        }

        updateBtn.addEventListener("click", async function (e) {
            e.preventDefault();

            successContainer.classList.remove('show');
            errorContainer.classList.remove('show');
            errorsElem.innerHTML = '';


            containerElem.classList.add('loading');
            migratingContainer.classList.add('show');


            const envResult = await getData("/api/update-env");

            if (envResult.status === 200) {




                setTimeout(async ()=>{

                    updateMsg.innerHTML = "{{__('lang.migrating')}}";
                    const res = await getData("/api/migration");

                    containerElem.classList.remove('loading');
                    migratingContainer.classList.remove('show');



                    if (res.status === 200) {

                        containerElem.classList.add('success');
                        successContainer.classList.add('show');

                        let sec = 1;
                        const interval = setInterval(()=>{
                            counterElem.textContent = sec;

                            if(sec === 3){
                                clearInterval(interval);
                                window.location.replace('/');

                            }
                            sec++;
                        }, 2000);

                        return


                    } else if (res.status === 201) {

                        errorContainer.classList.add('show');
                        res.data.form.forEach(i => {
                            const li = document.createElement('li');
                            li.textContent = i
                            errorsElem.appendChild(li);
                        });
                    }
                }, 2000)





            } else if (envResult.status === 201) {

                errorContainer.classList.add('show');
                envResult.data.form.forEach(i => {
                    const li = document.createElement('li');
                    li.textContent = i
                    errorsElem.appendChild(li);
                });
            }





        });

    }






</script>


</body>
</html>

