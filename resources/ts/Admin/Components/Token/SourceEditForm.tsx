import * as React from 'react';
import { Component } from 'react';

import { 
	TextareaControl,
	Flex,
	Disabled,
} from '@wordpress/components';

interface SourceEditFormProps {
	loading: boolean;
	onChange: any;
	editData: any;
}

interface SourceEditFormState {
	//
}

export default class SourceEditForm extends Component<SourceEditFormProps, SourceEditFormState> {
	state: SourceEditFormState = {
		source: null,
	};
	constructor( props: SourceEditFormProps ) {
		super( props );
		this.onWhitelistFieldChange = this.onWhitelistFieldChange.bind( this );
	}

	onWhitelistFieldChange( value: any ) {
		const state = Object.assign( {}, this.props.editData );
		state.assets = value;
		this.props.onChange( state );
	}

	render() {
		return (
			<form>
				<Flex style={ { maxWidth: "320px" } }>
					<Disabled
						//@ts-ignore
						isDisabled={ this.props.loading }
					>
						<TextareaControl
							label="Whitelisted Assets"
							help="Comma-separated values. Assets which are allowed for making promises."
							value={ this.props.editData.assets }
							onChange={ this.onWhitelistFieldChange }
						/>
					</Disabled>
				</Flex>
			</form>
		);
	}
}
