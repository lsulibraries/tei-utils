 declare default element namespace "http://www.tei-c.org/ns/1.0";
<test>
{for $p in collection("test?select=*.xml")//p

return
<p>
 {$p}
</p>
}
</test>