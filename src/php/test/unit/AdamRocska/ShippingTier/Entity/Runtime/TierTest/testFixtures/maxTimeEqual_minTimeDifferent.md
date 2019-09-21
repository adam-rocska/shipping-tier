# Test Fixture Description

**Given** a set of shipping method branches  
**When** there are two matches, out of which the maximum transit times are equal, but the minimum transit times are different  
**Then** the smaller minimum transit time should win.