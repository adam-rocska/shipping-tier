# Test Fixtures Description

The scope of this utility namespace, and its contents is to provide an easy way
to extend the tier unit's best branch match selection logic's test input.

# CSV Format

Test input is read from CSV files.  
Each test case's dataset is kept in a separate CSV file.  
CSV files **MUST NOT** have header rows. They **MUST ONLY** contain data entries.  
CSV file data entries are shipping method branches.  
The Data entry columns in order are as follows :
1. Should be the "winner" shipping method branch?
   * **TYPE** : `boolean`
   * **EXAMPLE** : `true`, `false`
2. Should Match Queried Stub Country?
   * **TYPE** : `boolean`
   * **EXAMPLE** : `true`, `false`
3. Minimum door-to-door transit time.
   * **TYPE** : `int`
   * **EXAMPLE** : `5`
4. Maximum door-to-door transit time.
   * **TYPE** : `int`
   * **EXAMPLE** : `10`

# Test Fixture Descriptions

Every test fixture must have its own description, to describe the edge case it covers.  
These descriptions :
* are kept in the same directory as the fixture.
* are of the exact same filename as the CSV file.
* are of Markdown type.
* have `.md` as their file extension.