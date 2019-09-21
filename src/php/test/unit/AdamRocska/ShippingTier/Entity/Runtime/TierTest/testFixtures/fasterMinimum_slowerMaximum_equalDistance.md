# Term Definitions

* `<P>` : A "P" type, where P represents the actual door to door transit time.
* `<P> = {min ∈ ℕ, max ∈ ℕ}` : "P type" definition, where P has a "`min`" and a"`max`" property, both of which are members of the natural numbers set. `min` represents the minimum time the shipment would take, `max` represents the maximum time.  
* `<P> ${NAME}` : A shipping method branch of name `${NAME}`
* `<P> A` : Shipping method branch A in the comparison logic.
* `<P> B` : Shipping method branch B in the comparison logic.
* `A.min` : **Minimum time** of shipping method branch **A**
* `A.max` : **Maximum time** of shipping method branch **A**

# Test Fixture Description

![Test Case Illustration](fasterMinimum_slowerMaximum_equalDistance.png) 

**Given** a set of shipping method branches  
**When** `A.min` is greater than `B.min`, **and** `A.max` is smaller than `B.max`  **and** `B.max` and `B.min` are of equal distance from `A.max` and `B.max`  
**Then** `<P> A` is considered to be faster.
