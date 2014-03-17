<!DOCTYPE html>
<!--
    Example HTML template file for uup/upp-mail.
-->
<html style="height: 90%%">
    <head>
        <style>
            h2 { color: #666; text-decoration: underline; }
            hr { border-top: 1px dashed #999; border-bottom: none; }
            td { vertical-align: top; }
            td.logo { background-color: #eaeaea; }
            td.body { padding-right: 10px; }
        </style>
    </head>
    <body style="height: 100%%">
        <table width="100%" style="height: 80%%">
            <tr>
                <td class="body" width="100%">
                    <h2>%1$s</h2>
                    <p>%2$s</p>%3$s
                    <br/>
                    <hr/><i>%4$s</i>
                    <hr/>%5$s
                </td>
                <td class="logo">
                    <img src="/images/uu_white/uulogo_white.gif"/>
                </td>
            </tr>
        </table>
    </body>
</html>
