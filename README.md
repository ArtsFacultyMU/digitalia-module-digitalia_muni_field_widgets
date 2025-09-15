This module provides custom field widgets for specific field types:

## Typed relation
The Typed relation field type is provided by Islandora module Controlled Access Terms. It consists of two subfields with fixed types: 
- Subfield Target ID (target_id): an Entity Reference subfield.
- Subfield Relationship type (rel_type): text value with predefined values.

By default, there is only one widget available for this field type: Typed Relation Widget. 
The rel_type subfield is displayed as a select list with label "Relationship Type" (this label cannot be changed in widget settings). 
The target_id subfield is displayed as an autocomplete field with no label.

Digitalia MUNI Field Widgets module provides additional widgets:

### Typed Relation Autocomplete widget
An enhanced version of the default widget. It behaves the same, but allows you to define custom labels for both subfields.

### Typed Relation Select list widget
Replaces the autocomplete input for the target_id subfield with a select list. As with the autocomplete widget, you can set custom labels for both subfields.
