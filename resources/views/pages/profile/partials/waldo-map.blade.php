<div class="modal fade" id="waldoMap" tabindex="-1" role="dialog" aria-labelledby="waldo-map-modal-title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="waldo-map-modal-title">Campus Map</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p id="waldo-map-message"></p>
                        <div id="room-map"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>
{{-- Allows this modal to be triggered by javasript. See waldo.js --}}
<span class="invisible">
    <button id="show-waldo-map-modal" data-toggle="modal" data-target="#waldoMap" ></button>
</span>
