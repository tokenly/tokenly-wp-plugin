import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import UserRepositoryInterface from '../../Interfaces/Repositories/UserRepositoryInterface';
import { TYPES } from '../../Types';

import { 
	// @ts-ignore
	ComboboxControl,
} from '@wordpress/components';

interface UserSearchFieldProps {
	onChange: any;
	user: any;
	label?: string;
	help?: string;
}

interface UserSearchFieldState {
	keywords: string;
	options: any;
	searchTimeout: number;
}

interface ComboboxOption {
	value: string,
	label: string,
}

export default class UserSearchField extends Component<UserSearchFieldProps, UserSearchFieldState> {
	@resolve( TYPES.Repositories.UserRepositoryInterface )
	userRepository: UserRepositoryInterface;
	
	state: UserSearchFieldState = {
		keywords: '',
		options: [],
		searchTimeout: 0,
	};
	constructor( props: UserSearchFieldProps ) {
		super( props );
		this.onKeywordsChange = this.onKeywordsChange.bind( this );
		this.getUserOptions = this.getUserOptions.bind( this );
		this.search = this.search.bind( this );
		this.getKeywordsFromOptions = this.getKeywordsFromOptions.bind( this );
	}
	
	getUserOptions( keywords: string ) {
		return new Promise( ( resolve, reject ) => {
			let options = [] as any;
			if ( keywords == '' ) {
				resolve( options );
			}
			this.searchDebounce( keywords ).then( ( optionsFound ) => {
				if ( optionsFound && Array.isArray( optionsFound ) ) {
					options = optionsFound;
				}
				this.setState( { options: options } );
				resolve( options );
			} ).catch( ( error ) => {
				reject( error );
			} );
		});
	}

	searchDebounce( keywords: string ) {
		clearTimeout( this.state.searchTimeout );
		return new Promise( ( resolve, reject ) => {
			this.state.searchTimeout = setTimeout(() => {
				const results = this.search( keywords );
				resolve( results );
			}, 500);
		} );
	}

	search( keywords: string ) {
		return new Promise( ( resolve, reject ) => {
			this.userRepository.index({
				suggestions: true,
				name: keywords,
			} ).then( ( results: Array<any> ) => {
				if ( results.length <= 0 ) {
					resolve( [] );
				} 
				const options = results.map( ( user: any ) => {
					return {
						value: user.id,
						label: user.name,
					} as ComboboxOption;
				} );
				if ( options.length > 1 ) {
					options.length = 1;
				}
				resolve( options );
			}).catch( ( error: string ) => {
				reject( error );
			} );
		} );
	}

	getKeywordsFromOptions() {
		let keywords = '';
		const options = this.state.options.filter( ( option: any ) => {
			return option.value == this.props.user;
		} );
		if ( options.length > 0 ) {
			keywords = options[0].label;
		}
		return keywords;
	}

	onKeywordsChange( keywords: string ) {
		if ( keywords == '' && this.props.user ) {
			keywords = this.getKeywordsFromOptions();
		}
		this.getUserOptions( keywords ).then( ( options ) => {
			this.setState( {
				options: options,
				keywords: keywords,
			} );
		} );
	}

	render() {
		return (
			<div style={ { height: '40px' } }>
				<ComboboxControl
					label={ this.props.label }
					help={ this.props.help }
					value={ this.props.user }
					onChange={ this.props.onChange }
					options={ this.state.options }
					onFilterValueChange={ this.onKeywordsChange }
				/>
			</div>
		);
	}
}
