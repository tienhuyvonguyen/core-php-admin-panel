<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<fieldset>
    <div class="form-group">
        <label for="f_name">Organization Name</label>
        <input type="text" name="name"
            value="<?php echo htmlspecialchars($edit ? $customer['f_name'] : '', ENT_QUOTES, 'UTF-8'); ?>"
            placeholder="First Name" class="form-control" required="required" id="f_name">
    </div>

    <div class="form-group">
        <label for="address">Bio</label>
        <textarea name="address" placeholder="Address" class="form-control"
            id="address"><?php echo htmlspecialchars(($edit) ? $customer['address'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email"
            value="<?php echo htmlspecialchars($edit ? $customer['email'] : '', ENT_QUOTES, 'UTF-8'); ?>"
            placeholder="E-Mail Address" class="form-control" id="email">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input name="phone"
            value="<?php echo htmlspecialchars($edit ? $customer['phone'] : '', ENT_QUOTES, 'UTF-8'); ?>"
            placeholder="987654321" class="form-control" type="text" id="phone">
    </div>
    <div class="form-group">
        <label class="control-label">Appointment Time</label>
        <div class='input-group date' id='datetimepicker1'>
            <input type='text' class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label">Appointment Time</label>
        <div class='input-group date' id='datetimepicker1'>
            <input type='text' class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning">Save <span class="glyphicon glyphicon-send"></span></button>
    </div>
</fieldset>