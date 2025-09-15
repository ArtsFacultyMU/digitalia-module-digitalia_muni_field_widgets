This module provides custom field widgets for specific field types:

## Typed relation
The Typed relation field type is provided by Islandora module Controlled Access Terms. It consists of two subfields with fixed types: 
- Subfield Target ID (target_id): an Entity Reference subfield.
- Subfield Relationship type (rel_type): text value with predefined values.

By default, there is only one widget available for this field type: Typed Relation Widget.
- The rel_type subfield is displayed as a select list with label "Relationship Type". This label cannot be changed in widget settings. The widget displays the default value as the first item in the allowed values, instead of empty value (NULL).
- The target_id subfield is displayed as an autocomplete field with no label. Default value is NULL (which is correct).

**Digitalia MUNI Field Widgets** module provides additional widgets:

### Typed Relation Autocomplete widget
An enhanced version of the default widget. It allows you to define custom labels for both subfields and adds default value NULL for subfield rel_type.

### Typed Relation Select list widget
Replaces the autocomplete input for the target_id subfield with a select list. As with the autocomplete widget, you can set custom labels for both subfields. The default value in rel_type is set to NULL.
