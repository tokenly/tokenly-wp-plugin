import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { UserRepositoryInterface } from '../../Interfaces/Repositories/UserRepositoryInterface';
import { UserSuggestion } from '../../Interfaces';
import { TYPES } from '../../Types';

declare const wp: any;

const { __ } = wp.i18n;

import { 
	// @ts-ignore
	ComboboxControl,
} from '@wordpress/components';

interface UserSearchFieldProps {
	onChange: any;
	label?: string;
	help?: string;
}

interface UserSearchFieldState {
	keywords: string;
	user: number;
	users: Array<ComboboxOption>;
}

interface ComboboxOption {
	value: string,
	label: string,
}

export class UserSearchField extends Component<UserSearchFieldProps, UserSearchFieldState> {
	@resolve( TYPES.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;
	
	state: UserSearchFieldState = {
		keywords: null,
		user: null,
		users: [],
	};
	constructor( props: UserSearchFieldProps ) {
		super( props );
		this.onKeywordsChange = this.onKeywordsChange.bind( this );
		this.onUserChange = this.onUserChange.bind( this );
	}
	
	onKeywordsChange( keywords: string ) {
		if( keywords == '' ) {
			return;
		}
		this.setState( { keywords: keywords } );
		this.userRepository.index({
			suggestions: true,
			name: keywords,
		}).then( ( results: Array<UserSuggestion> ) => {
			if ( results.length <= 0 ) {
				return;
			} 
			const options = results.map( ( user: any ) => {
				return {
					value: user.id,
					label: user.name,
				} as ComboboxOption;
			} );
			this.setState( { users: [options[0]] } );
		}).catch( ( error: string ) => {
			console.log( error );
		} );
	}
	
	onUserChange( id: number ) {
		this.setState( { user: id} );
		this.props.onChange( id );
	}

	render() {
		return <div style={{height: '40px'}}>
			<ComboboxControl
				label={ this.props.label }
				help={ this.props.help }
				value={ this.state.user }
				onChange={ (value: any) => {
					this.onUserChange( value );
				} }
				options={ this.state.users }
				onFilterValueChange={ ( keywords: string ) => {
					this.onKeywordsChange( keywords );
				} }
			/>
		</div>
	}
}
