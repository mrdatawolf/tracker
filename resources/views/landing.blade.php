@extends('layouts.master')

@section('main')
    <div class="content">
        <div id="userInfo">
            <H3>-User-</H3>
            <title>Name</title><input type="text" id="clientName"><br>notes: autofill with known names
            <hr>
            <h4>Contact Info</h4>
            <input id="primaryContactOption" type="radio" checked><label for="clientPhone">Primary Phone</label><input
                    type="text" id="clientPhone"><br>
            <input id="primaryContactOption" type="radio"><label for="clientEmail">Email</label><input type="text"
                                                                                                       id="clientEmail"><br>
            <input id="primaryContactOption" type="radio"><label for="clientOther">Other</label><input type="text"
                                                                                                       id="clientOther">
            <hr>
            <h4>Notes</h4>
            <textarea id="clientNotes"></textarea>
        </div>
        <div id="userData">
            <div id="ongoingComics">
                <H4>Ongoing Comics</H4>
                <ul>
                    <li style=" text-decoration:line-through;">Daredevil</li>
                    <li>Invincible Iron Man (~blurred~ w/Marvel NOW)</li>
                    <li style=" text-decoration:line-through;">Gaurdians of the galaxy ~blurred note here ~</li>
                    <li>Old Man Logan</li>
                    <li>~~add new comic~~</li>
                </ul>
            </div>
            <div id="missingFillComics">
                <H4>Missing Comics Wanted</H4>
                <ul>
                    <li style=" text-decoration:line-through;">some comic #1</li>
                    <li>New Wolverine #11</li>
                    <li style=" text-decoration:line-through;">Gaurdians of the galaxy ~blurred note here ~</li>
                    <li>Old Man Logan</li>
                    <li>~~add new comic~~</li>
                </ul>
            </div>
            <div id="limitedSeriesAndIssues">
                <H4>Limited Series & Issues</H4>
                <ul>
                    <li style=" text-decoration:line-through;">Civil War II</li>
                    <li>Civil War II Kingpin</li>
                    <li style=" text-decoration:line-through;">Gaurdians of the galaxy ~blurred note here ~</li>
                    <li>Old Man Logan</li>
                    <li>~~add new comic~~</li>
                </ul>
            </div>
        </div>
        <div id="apply">
            <button id="applyChanges">Apply changes!</button>
        </div>
    </div>
    </div>
@stop

@section('scriptFooter')
    <script type="application/javascript">
        var clientName = '';

        function updateUserInfo() {
            clientName = $('#clientName').val();
            var clientPhone = $('#clientPhone').val();
            var clientEmail = $('#clientEmail').val();
            var clientOther = $('#clientOther').val();
            var clientNotes = $('#clientNotes').val();
            console.log('Apply changes to userData of ' + clientName);
        }

        function getUserInfo() {

            console.log('Get user info from db for ' + clientName);
        }

        function updateUserComics() {
            console.log('here we would update all the comics for ' + clientName);
        }

        $(function () {
            $('#applyChanges').click(function () {
                updateUserInfo();
            });

            $('#clientName').blur(function () {
                getUserInfo();
            });
        });
    </script>
@stop
