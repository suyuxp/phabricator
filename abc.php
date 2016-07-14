<?php

$gugud_ldap_connect = ldap_connect("gugud.com");  // assuming the LDAP server is on this host

if ($gugud_ldap_connect) {
    // bind with appropriate dn to give update access
    ldap_set_option($gugud_ldap_connect, LDAP_OPT_PROTOCOL_VERSION, 3);
    $gugud_r = ldap_bind($gugud_ldap_connect, "cn=admin,dc=gugud,dc=com", "ts3qdf");

    // prepare data
    $gugud_user_entry["uid"] = $value_username;
    $gugud_user_entry["cn"] = $value_realname;

    $gugud_user_entry["userpassword"] = $value_password;
    $gugud_user_entry["sn"] = "Jones";
    $gugud_user_entry["givenname"] = "Jones";
    $gugud_user_entry["objectclass"][0] = "inetOrgPerson";
    $gugud_user_entry["objectclass"][1] = "organizationalPerson";
    $gugud_user_entry["objectclass"][2] = "person";
    $gugud_user_entry["objectclass"][3] = "top";

    // add data to directory
    $gugud_r = ldap_add($gugud_ldap_connect, "uid=" . $value_username . ",ou=people,dc=gugud,dc=com", $gugud_user_entry);

    ldap_close($gugud_ldap_connect);
} else {
    echo "Unable to connect to LDAP server";
}

?>