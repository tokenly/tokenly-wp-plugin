import * as React from 'react';
import { useState } from 'react';
import { useInjection } from 'inversify-react';
import UserRepositoryInterface from '../../Interfaces/Repositories/UserRepositoryInterface';
import { TYPES } from '../../Types';
import Autocomplete from './Autocomplete';

import { 
	// @ts-ignore
	TextControl
} from '@wordpress/components';

interface UserSearchFieldProps {
	onChange: any;
	user: any;
	label?: string;
	help?: string;
	inputProps?: any;
}

interface ComboboxOption {
	value: string,
	label: string,
}

export default function UserSearchField( props: UserSearchFieldProps ) {
	const userRepository: UserRepositoryInterface = useInjection( TYPES.Repositories.UserRepositoryInterface );

	const [ focused, setFocused ] = useState<boolean>( false );
	const [ keywords, setKeywords ] = useState( '' );
	const [ options, setOptions ] = useState( [] );
	const [ searchTimeout, setSearchTimeout ] = useState<any>( 0 );
	
	function getUserOptions( keywords: string ) {
		return new Promise( ( resolve, reject ) => {
			let newOptions = [] as any;
			if ( keywords == '' ) {
				resolve( newOptions );
			}
			searchDebounce( keywords ).then( ( optionsFound ) => {
				if ( optionsFound && Array.isArray( optionsFound ) ) {
					newOptions = optionsFound;
				}
				setOptions( newOptions );
				resolve( newOptions );
			} ).catch( ( error ) => {
				reject( error );
			} );
		});
	}

	function searchDebounce( keywords: string ) {
		clearTimeout( searchTimeout );
		return new Promise( ( resolve, reject ) => {
			setSearchTimeout( setTimeout( () => {
				const results = search( keywords );
				resolve( results );
			}, 500) );
		} );
	}

	function search( keywords: string ) {
		return new Promise( ( resolve, reject ) => {
			userRepository.index( {
				suggestions: true,
				name: keywords,
			} ).then( ( results: Array<any> ) => {
				if ( results.length <= 0 ) {
					resolve( [] );
				} 
				const options = results.map( ( user: any ) => {
					return {
						value: user.name,
						label: user.name,
					} as ComboboxOption;
				} );
				if ( options.length > 3 ) {
					options.length = 3;
				}
				resolve( options );
			} ).catch( ( error: string ) => {
				reject( error );
			} );
		} );
	}

	function getKeywordsFromOptions() {
		let keywords = '';
		const optionsFiltered = options.filter( ( option: any ) => {
			return option.value == props.user;
		} );
		if ( optionsFiltered.length > 0 ) {
			keywords = optionsFiltered[0].label;
		}
		return keywords;
	}

	function onKeywordsChange( keywords: string ) {
		props.onChange( keywords );
		if ( keywords == '' && props.user ) {
			keywords = getKeywordsFromOptions();
		}
		getUserOptions( keywords ).then( ( options: any ) => {
			setOptions( options );
			setKeywords( keywords );
		} );
	}

	return (
		<div className="tokenly-search">
			<input type="text" { ...props.inputProps } style={ { height: '0px', minHeight: '0px', opacity: 0 } } value={ props.user } />
			<TextControl
				label={ props.label }
				value={ props.user }
				onChange={ onKeywordsChange }
				onFocus={ () => {
					setFocused( true );
				} }
				onBlur={ ( event: any ) => {
					setFocused( false );
				} }
			/>
		{ ( focused && options.length > 0 ) &&
			<Autocomplete onChange={ onKeywordsChange } options={ options } />
		}
		</div>
	);
}
