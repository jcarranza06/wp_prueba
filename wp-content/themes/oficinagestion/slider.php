<?php
class Slider
{
    function createSlider($list, $t)
    {
        setSlider($list, $t);
    }
}
function setSlider($list, $time)
{
    ?>
    <div id="slider-container">
        <div id="slider">
            <div id="slider-image-container">
                <div id="slider-prev" class="slider-image"></div>
                <div id="slider-main" class="slider-image">
                </div>
                <div id="slider-next" class="slider-image">
                </div>
            </div>
        </div>
        <div id="slider-btn-container">
            <div id="slider-btn-left">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="80px"
                    viewBox="0 0 130.000000 200.000000" preserveAspectRatio="xMidYMid meet">

                    <g transform="translate(0.000000,200.000000) scale(0.100000,-0.100000)" fill="#5B5B5B" stroke="none">
                        <path d="M1007 1975 c-22 -7 -49 -22 -60 -32 -12 -11 -161 -146 -332 -299
                                -171 -154 -366 -331 -435 -392 -72 -65 -134 -130 -148 -154 -43 -79 -24 -179
                                46 -242 81 -75 586 -539 722 -665 80 -74 158 -142 174 -152 130 -79 306 28
                                306 186 0 41 -42 127 -73 151 -13 10 -161 145 -327 299 -167 154 -316 291
                                -333 305 l-29 25 139 125 c76 69 235 212 353 319 267 241 292 278 259 396 -15
                                52 -82 119 -134 134 -52 14 -81 13 -128 -4z" />
                    </g>
                </svg>
            </div>
            <div id="slider-btn-right">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25px" height="80px"
                    viewBox="0 0 130.000000 200.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,200.000000) scale(0.100000,-0.100000)" fill="#5B5B5B" stroke="none">
                        <path d="M155 1975 c-77 -30 -134 -110 -135 -190 0 -88 21 -113 392 -450 191
                                -173 350 -319 353 -325 3 -5 -20 -34 -52 -63 -32 -29 -194 -178 -360 -330
                                -167 -153 -310 -292 -319 -310 -25 -47 -23 -133 4 -184 52 -99 174 -139 273
                                -87 16 8 217 187 447 397 230 211 432 393 449 405 46 33 87 121 81 175 -10 84
                                -29 106 -341 390 -166 151 -369 336 -452 411 -82 76 -163 144 -178 152 -42 22
                                -116 26 -162 9z" />
                    </g>
                </svg>
            </div>
        </div>
        <div id="slider-nav-circles-container">
            <div class="nav-circle main"></div>
            <?php 
            for ($i = 1; $i < count($list); $i++) {
            ?>
            <div class="nav-circle"></div>
            <?php }
            ?>
        </div>
    </div>

    <style type="text/css">
        #big {
            width: 100%;
            height: 500px;
        }

        #slider {
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        #slider-image-container {
            display: flex;

            height: 100%;
            width: 300%;
        }

        #slider-nav-circles-container {
            position: relative;
            width: 100%;
            opacity: 0.5;
            z-index: 4;
            display: inline-flex;
            justify-content: center;
            top: -50%;
        }

        .nav-circle {
            margin: 8px;
            background-color: #000000;
            content: "*";
            width: 14px;
            height: 14px;
            border-radius: 100%;
        }

        .nav-circle.main {
            background-color: #ffffff;
        }

        @keyframes toBlack{
            0% {
                background-color: #ffffff;
            }

            80% {
                background-color: #000000;
            }

            100% {
                background-color: #000000;
            }
        }

        @keyframes toWhite {
            0% {
                background-color: #000000;
            }

            80% {
                background-color: #ffffff;
            }
            
            100% {
                background-color: #ffffff;
            }
        }

        .slider-image {
            position: relative;
            height: 100%;
            width: 100%;
            float: left;
            transform: translateX(-100%);

            animation-duration: 1s;
        }

        #slider-btn-container {
            position: relative;
            width: 100%;
            top: -50%;
            opacity: 0.8;
            z-index: 4;
        }

        #slider-btn-left {
            position: relative;
            width: fit-content;
            margin-inline: 20px;
            float: left;
        }

        #slider-btn-right {
            position: relative;
            width: fit-content;
            float: right;
            margin-inline: 20px;
        }

        #slider-btn-container svg {
            transition: 0.5s;
        }

        #slider-btn-container svg:hover {
            width: 30px;
        }
		#slider-btn-left svg {
			filter: drop-shadow(-2px 0px 0px #dddddd);
		}
		#slider-btn-right svg {
			filter: drop-shadow(2px 0px 0px #dddddd);
		}
		#slider-btn-left svg:hover {
			filter: drop-shadow(-10px 0px 0px #dddddd);
		}
		#slider-btn-right svg:hover {
			filter: drop-shadow(10px 0px 0px #dddddd);
		}

        .backimg .head-container {
            position: relative;
            z-index: 2;
        }

        #slider-container {
            position: absolute;
            z-index: 1;
			overflow: hidden;
			min-height: 300px;
        }

        @keyframes moveLeft {
            0% {
                transform: translateX(-100%);
            }

            95% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(0%);
            }
        }

        @keyframes moveRight {
            0% {
                transform: translateX(-100%);
            }

            95% {
                transform: translateX(-200%);
            }

            100% {
                transform: translateX(-200%);
            }
        }
    </style>

    <script type="text/javascript">
        list = <?php echo json_encode($list); ?>;
        act = 0;
        time = <?php echo $time ?>

        sliderBtnLeft = document.getElementById("slider-btn-left");
        sliderBtnRight = document.getElementById("slider-btn-right");
        sliderContainer = document.getElementById("slider-container")
        sliderContainerParent = sliderContainer.parentElement;
        sliderNavCirlcesContainer = document.getElementById("slider-nav-circles-container")

        setContainerSize();
        prev = document.getElementById("slider-prev")
        main = document.getElementById("slider-main")
        next = document.getElementById("slider-next")

        main.style.background = "border-box url(" + list[act] + ") center/cover no-repeat";
        sliderBtnLeft.onclick = function () {
            moveLeft();
        }
        sliderBtnRight.onclick = function () {
            moveRight();
        }
        function setContainerSize() {
            elem = sliderContainerParent.getBoundingClientRect();
			console.log("padre: "+ elem.top+" scroll: "+window.scrollY +" suma " + (elem.top+window.scrollY));
            sliderContainer.style.top = (elem.top+window.scrollY) + 'px';
            sliderContainer.style.left = elem.left + 'px';
            sliderContainer.style.height = elem.height + 'px';
            sliderContainer.style.width = elem.width + 'px';
        }

        window.addEventListener('resize', function(event) {
            setContainerSize();
        }, true);

        function moveLeft() {
            pAct=act;
            sliderNavCirlcesContainer.children[act].style.animation="toBlack 1s";
            image = getPrev();
            prev.style.background = "border-box url(" + image + ") center/cover no-repeat";
            sliderNavCirlcesContainer.children[act].style.animation="toWhite 1s";
            setTimeout(function () {
                main.style.background = "border-box url(" + image + ") center/cover no-repeat";
                prev.style.animationName = ''
                main.style.animationName = ''
                sliderNavCirlcesContainer.children[pAct].style.backgroundColor = "#000000"
                sliderNavCirlcesContainer.children[act].style.backgroundColor = "#ffffff"
                sliderNavCirlcesContainer.children[pAct].style.animation="";
                sliderNavCirlcesContainer.children[act].style.animation="";
            }, 995);
            prev.style.animationName = 'moveLeft'
            main.style.animationName = 'moveLeft'
        }

        function moveRight() {
            pAct=act;
            sliderNavCirlcesContainer.children[act].style.animation="toBlack 1s";
            image = getNext();
            next.style.background = "border-box url(" + image + ") center/cover no-repeat";
            sliderNavCirlcesContainer.children[act].style.animation="toWhite 1s";
            setTimeout(function () {
                main.style.background = "border-box url(" + image + ") center/cover no-repeat";
                next.style.animationName = ''
                main.style.animationName = ''
                sliderNavCirlcesContainer.children[pAct].style.backgroundColor = "#000000"
                sliderNavCirlcesContainer.children[act].style.backgroundColor = "#ffffff"
                sliderNavCirlcesContainer.children[pAct].style.animation="";
                sliderNavCirlcesContainer.children[act].style.animation="";
            }, 995);
            main.style.animationName = 'moveRight'
            next.style.animationName = 'moveRight'
        }
        function getPrev() {
            return list[(act == 0) ? act = list.length - 1 : act -= 1];
        }
        function getNext() {
            return list[(act == (list.length - 1)) ? act = 0 : act += 1];
        }
        window.addEventListener('load', function () {
            startSlider();
        });

        function startSlider() {
            setTimeout(function () {
                moveRight();
                startSlider();
            }, time);
        }
    </script>

    <?php
}


?>