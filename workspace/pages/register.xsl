<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:import href="../utilities/master.xsl"/>
<xsl:import href="../utilities/registration-form.xsl"/>

<xsl:template match="data">
	<xsl:choose>
		<xsl:when test="$member/@logged-in = 'true'">
			<h2>Members Area</h2>
			<h3>Welcome, <xsl:value-of select="$member/first-name"/></h3>
			<p>You have already registered as a member of the
				<em><xsl:value-of select="$website-name"/></em> site. 
				Click here to <a href="?member-action=logout">logout</a>.</p>
			<hr/>
		</xsl:when>
		<xsl:otherwise>
			<h2>Members Only</h2>
			<h3>Register</h3>
			<p>If you have not already registered as a member of the <em><xsl:value-of select="$website-name"/></em> site, please enter your login information here. If you are already a member, please <a href="{$root}/login/">login</a>.</p>
			<hr/>
			<h2>Registration Form</h2>
			<div id="guideline">
				<h4>Notes</h4>
				<ul>
					<li>If you are already a member, please <a href="{$root}/login/">login</a>.</li>
				</ul>
			</div>
			<xsl:call-template name="registration-form"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>
	
</xsl:stylesheet>