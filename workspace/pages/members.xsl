<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="../utilities/master.xsl"/>
<xsl:import href="../utilities/login-panel.xsl"/>

<xsl:template match="data">
	<xsl:choose>
		<xsl:when test="$member/@logged-in = 'true'">
			<h2>Members Area</h2>
			<h3>Welcome, <xsl:value-of select="$member/first-name"/></h3>
			<p>You have successfully logged in as a member of the
				<em><xsl:value-of select="$website-name"/></em> site. 
				Click here to <a href="?member-action=logout">logout</a>.</p>
			<hr/>
		</xsl:when>
		<xsl:otherwise>
			<h2>Members Only</h2>
			<h3>Login</h3>
			<p>If you have already registered as a member of 
				<em><xsl:value-of select="$website-name"/></em>, 
				please enter your login information here. 
				If you are not yet a member, please 
				<a href="{$root}/register/">register</a>.</p>
			<hr/>
			<xsl:call-template name="login-panel"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>
	
</xsl:stylesheet>