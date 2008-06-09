
== Use of frontend == 

When you want to use the FakeQuickpay frontend you will need to make a couple of
modifications.

1) move fake_quickpay_server.php to the same directory as the fil from where you
are make a post request to the quickpay server.

2) Modify fake_quickpay_server.php with a the MD5_secret or a constant containing the
value.

If you do not want to have the fake_quickpay_server.php in the same directory from
where you are making the post request, you can edit the path in 
Payment_Html_Provider_FakeQuickpay_Prepare->__construct


