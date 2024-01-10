<link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

<div class="container-fruid1" style="background-color: #6d5092">
    <div class="navbar font-medium">
        <div class="logic">LUXID DREAM</div>
        <ul>
            <li>
                <a href="{{ Route('HomePage') }}">Home</a>
            </li>
            <li>
                <a href="rulepage">Rule</a>
            </li>
            <li>
                <a href="{{ Route('AboutPage') }}">About</a>
            </li>
        </ul>
        <div class="d-flex ms-auto">
            <ul>
                <li class="no-hover">
                <select class="form-select bg-black border-0">
                    <option [selected]="lang === 'en'" value="en">
                        eng
                    </option>
                    <option [selected]="lang === 'th'" value="th">
                        thai
                    </option>
                </select>
                </li>
                <li class="no-hover">
                    <a href="login" class="link-button">login</a>
                </li>
            </ul>
        </div>
    </div>
</div>